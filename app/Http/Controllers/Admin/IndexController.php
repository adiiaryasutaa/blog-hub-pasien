<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use App\Models\ViewedBlog;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
	private UserService $userService;

	/**
	 * @param UserService $userService
	 */
	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

	/**
	 * @param Request $request
	 * @return Application|Factory|View
	 */
	public function index(Request $request)
	{
		$user = auth()->user();

		return view('page.admin.dashboard.index', [
			'totalAllBlogs' => Blog::count(),
			'totalBlogsOwned' => $user->blogs()->count(),
			'totalViewers' => 429,
			'totalViewersToday' => 43,

			'mostViewedBlogs' => Blog::with(['author'])->get()->random(5),
			'mostViewedCategories' => Category::all()->random(5),

			'user' => $user,
		]);
	}
}
