<?php

namespace App\Services\Impl;

use App\Enums\BlogStatus;
use App\Models\Blog;
use App\Models\User;
use App\Services\TrashService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Blog_C;
use LaravelIdea\Helper\App\Models\_IH_Blog_QB;
use League\Flysystem\UnableToDeleteFile;
use Storage;
use Throwable;

class TrashServiceImpl implements TrashService
{
	/**
	 * @inheritDoc
	 */
	public function getAllTrashedBlogs(User $user)
	{
		return $user
			->blogs()
			->onlyTrashed();
	}

	/**
	 * @param Blog $blog
	 * @return Blog|Blog[]|Builder|Builder[]|Collection|Model|_IH_Blog_C|_IH_Blog_QB|_IH_Blog_QB[]|null
	 */
	public function prepareBlogForView(Blog $blog)
	{
		return $blog
			->onlyTrashed()
			->with(['author', 'categories:name'])
			->find($blog->id);
	}

	/**
	 * @inheritDoc
	 */
	public function restoreBlog(Blog $blog)
	{
		try {
			DB::beginTransaction();

			throw_unless($blog->restore());

			DB::commit();
			return true;
		} catch (Throwable $e) {
			DB::rollBack();
			return false;
		}
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function restoreAllBlogs(User $user)
	{
		try {
			DB::beginTransaction();

			$blogs = $this->getAllTrashedBlogs($user);

			$blogs->update(['status' => BlogStatus::ARCHIVED->value]);
			throw_unless($blogs->restore());

			DB::commit();
			return true;
		} catch (Throwable $e) {
			DB::rollBack();
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function forceDeleteBlog(Blog $blog)
	{
		try {
			DB::beginTransaction();

			throw_unless(
				Storage::disk('public')->delete('blog/thumbnail/' . $blog->thumbnail),
				UnableToDeleteFile::class
			);

			throw_unless($blog->forceDelete());

			DB::commit();
			return true;
		} catch (Throwable $e) {
			DB::rollBack();
			return false;
		}
	}

	public function forceDeleteAllBlogs(User $user)
	{
		try {
			DB::beginTransaction();

			$blogs = $this->getAllTrashedBlogs($user);

			throw_unless($blogs->forceDelete());

			DB::commit();
			return true;
		} catch (Throwable $e) {
			DB::rollBack();
			return false;
		}
	}
}
