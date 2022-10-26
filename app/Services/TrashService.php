<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface TrashService
{
	/**
	 * @param User $user
	 * @return HasMany
	 */
	public function getAllTrashedBlogs(User $user);

	/**
	 * @param Blog $blog
	 * @return mixed
	 */
	public function restoreBlog(Blog $blog);

	/**
	 * @param Blog $blog
	 * @return mixed
	 */
	public function forceDeleteBlog(Blog $blog);
}
