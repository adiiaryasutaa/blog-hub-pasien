<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BlogService;

class UserBlogManagerController extends Controller
{
	private BlogService $blogService;

	/**
	 * @param BlogService $blogService
	 */
	public function __construct(BlogService $blogService)
	{
		$this->blogService = $blogService;
	}

	public function index(User $user)
	{
		$blogs = $this->blogService->getAllBlogs($user);

		return view('page.admin.blog.index', [
			'user' => $user,
			'blogs' => $blogs,
		]);
	}
}
