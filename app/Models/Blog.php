<?php

namespace App\Models;

use App\Enums\BlogStatus;
use App\Events\BlogDeleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $guarded = ['id'];

	protected static function boot()
	{
		parent::boot(); // TODO: Change the autogenerated stub

		self::restored(function (Blog $blog) {
			$blog->update(['status' => BlogStatus::ARCHIVED->value]);
		});

		self::forceDeleted(function (Blog $blog) {
			event(new BlogDeleted($blog));
		});
	}

	/**
	 * Get the user who created the blog
	 * @return BelongsTo
	 */
	public function author(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function categories(): BelongsToMany
	{
		return $this->belongsToMany(Category::class);
	}

	public function views()
	{
		return $this->hasMany(ViewedBlog::class, 'blog_id');
	}

	/**
	 * @return string
	 */
	public function authorName(): string
	{
		return $this->author()->first()->name;
	}

	public function categoryList($separator = ', ')
	{
		$categories = $this->categories()->get(['name']);
		$size = $categories->count();

		$list = '';

		foreach ($categories as $index => $category) {
			$list .= $category->name . (++$index !== $size ? $separator : '');
		}

		return $list;
	}

	/**
	 * @return array|Blog[]
	 */
	public function similarBlogs(array|string $columns = ['*']): array
	{
		$ids = [];
		$similar = $this->hasMany(SimilarBlog::class)->select(['similar_with_id'])->get();

		foreach ($similar as $a) {
			$ids[] = $a->similar_with_id;
		}

		return self::withTrashed()->select($columns)->whereIn('id', $ids)->get()->all();
	}

	/**
	 * @return bool
	 */
	public function archived(): bool
	{
		return $this->status === BlogStatus::ARCHIVED->value;
	}
}
