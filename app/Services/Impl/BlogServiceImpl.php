<?php

namespace App\Services\Impl;

use App\Enums\BlogStatus;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use App\Services\BlogService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaravelIdea\Helper\App\Models\_IH_Blog_C;
use LaravelIdea\Helper\App\Models\_IH_Blog_QB;
use League\Flysystem\UnableToDeleteFile;
use Throwable;

class BlogServiceImpl implements BlogService
{
	/**
	 * @inheritDoc
	 */
	public function getAllBlogs(User $user, array|string $columns = ['*'])
	{
		return $user->blogs;
	}

	/**
	 * @param Blog $blog
	 * @return Blog|Builder|Collection|Model|_IH_Blog_C|_IH_Blog_QB|null
	 */
	public function prepareBlogForView(Blog $blog)
	{
		return $blog->with(['author', 'categories:name'])->find($blog->id);
	}

	/**
	 * @inheritDoc
	 */
	public function createBlog(User $user, array $data, bool $archived = true)
	{
		try {
			$categories = Arr::unsetIfNullOrEmpty($data['categories']);
			$data = $this->prepareBlogData($data);

			DB::beginTransaction();

			$blog = $user->blogs()->create($data);

			$this->createAndAttachCategory($blog, $categories);

			DB::commit();
			return $blog;
		} catch (Throwable $e) {
			DB::rollBack();
			return null;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function updateBlog(Blog $blog, array $data = [])
	{
		$data = Arr::unsetIfNullOrEmpty($data);
		$categories = Arr::unsetIfNullOrEmpty($data['categories']);

		try {
			$data = $this->prepareBlogDataForUpdate($blog, $data);

			if (empty($data) && empty($categories)) {
				return true;
			}

			DB::beginTransaction();

			$blog->updateOrFail($data);
			$this->createAndAttachCategory($blog, $categories);

			DB::commit();
			return true;
		} catch (Throwable $e) {
			DB::rollBack();
			return false;
		}
	}

	/**
	 * @param array $data
	 * @return array
	 * @throws Throwable
	 */
	public function prepareBlogData(array $data = [])
	{
		return [
			'thumbnail' => $this->putThumbnail($data['thumbnail']),
			'title' => str($data['title'])->title(),
			'slug' => str(Str::uuid() . ' ' . $data['title'])->slug(),
			'excerpt' => str(strip_tags($data['content']))->excerpt(options: ['radius' => 250]),
			'content' => $data['content'],
			'status' => $data['archived'] ? BlogStatus::ARCHIVED : BlogStatus::PUBLISHED,
		];
	}

	/**
	 * @param Blog $blog
	 * @param array $data
	 * @return array
	 * @throws Throwable
	 */
	public function prepareBlogDataForUpdate(Blog $blog, array $data = [])
	{
		$d = [];

		if (Arr::has($data, 'thumbnail')) {
			$d['thumbnail'] = $this->putOrReplaceThumbnail($blog->thumbnail, $data['thumbnail']);
		}

		if (Arr::has($data, 'title') && $data['title'] !== $blog->title) {
			$d['title'] = str($data['title'])->title();
			$d['slug'] = str(Str::uuid() . ' ' . $data['title'])->slug();
		}

		if (Arr::has($data, 'content') && $data['content'] !== $blog->content) {
			$d['excerpt'] = str(strip_tags($data['content']))->excerpt(options: ['radius' => 250]);
			$d['content'] = $data['content'];
		}

		if (Arr::has($data, 'archived')) {
			$d['status'] = $data['archived'] ? BlogStatus::ARCHIVED : BlogStatus::PUBLISHED;
		}

		return $d;
	}

	/**
	 * @param UploadedFile $file
	 * @return string
	 */
	public function putThumbnail(UploadedFile $file): string
	{
		$filename = Str::random(50) . '.' . $file->getClientOriginalExtension();
		$path = "blog/thumbnail/$filename";

		Storage::disk('public')->put($path, file_get_contents($file));

		return $filename;
	}

	/**
	 * @param $path
	 * @param UploadedFile|string $file
	 * @return string
	 * @throws Throwable
	 */
	public function putOrReplaceThumbnail($path, UploadedFile|string $file)
	{
		$storage = Storage::disk('public');
		$path = "blog/thumbnail/$path";

		if ($storage->exists($path)) {
			throw_unless($storage->delete($path), UnableToDeleteFile::atLocation($path));
		}

		return $this->putThumbnail($file);
	}

	/**
	 * @param Blog $blog
	 * @param array $categories
	 * @return void
	 */
	public function createAndAttachCategory(Blog $blog, array $categories = [])
	{
		$ids = [];

		foreach ($categories as $category) {
			$ids[] = Category::firstOrCreate([
				'name' => $category,
			], [
				'name' => $category,
			])->id;
		}

		$blog->categories()->sync($ids);
	}

	/**
	 * @param Blog $blog
	 * @return bool
	 */
	public function uploadBlog(Blog $blog)
	{
		try {
			return $blog->updateOrFail(['status' => BlogStatus::PUBLISHED->value]);
		} catch (Throwable $e) {
			return false;
		}
	}

	/**
	 * @param Blog $blog
	 * @return bool
	 */
	public function delete(Blog $blog): bool
	{
		try {
			DB::beginTransaction();

			$blog->deleteOrFail();
			$blog->updateOrFail(['status' => BlogStatus::DELETED->value]);

			DB::commit();

			return true;
		} catch (Throwable $e) {
			DB::rollBack();
			return false;
		}
	}
}
