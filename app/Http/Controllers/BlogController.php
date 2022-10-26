<?php

namespace App\Http\Controllers;

use App\Enums\BlogStatus;
use App\Events\BlogViewed;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
	public function index(Request $request)
	{
		$page = $request->integer('page', 1);

		$blogs = Blog::with(['categories', 'author'])
			->whereStatus(BlogStatus::PUBLISHED)
			->orderBy('created_at')
			->paginate(9);

		return view('page.index', ['blogs' => $blogs]);
	}

	public function view(Request $request, Blog $blog)
	{
		$blog = $blog
			->with(['categories', 'author'])
			->whereStatus(BlogStatus::PUBLISHED)
			->find($blog->id);

		if (is_null($request->user())) {
			event(new BlogViewed($blog));
		}

		return view('page.view', ['blog' => $blog]);
	}
}
