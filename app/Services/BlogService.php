<?php

namespace App\Services;

use App\Models\User;
use App\Models\Blog;

interface BlogService
{
	/**
	 * @param User $user
	 * @param string|array $columns
	 * @return array
	 */
	public function getAllBlogs(User $user, array|string $columns);

	/**
	 * @param User $user
	 * @param array $data
	 * @param bool $archived
	 * @return ?Blog
	 */
	public function createBlog(User $user, array $data, bool $archived);

	/**
	 * @param Blog $blog
	 * @param array $data
	 * @return bool
	 */
	public function updateBlog(Blog $blog, array $data);
}
