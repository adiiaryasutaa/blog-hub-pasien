<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Services\BlogService;
use App\Services\TrashService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
	private BlogService $blogService;

	/**
	 * @param BlogService $blogService
	 */
	public function __construct(BlogService $blogService)
	{
		$this->blogService = $blogService;
	}

	/**
	 * @param Request $request
	 * @return Application|Factory|View
	 */
	public function index(Request $request)
	{
		$user = auth()->user();

		$blogs = $this->blogService->getAllBlogs($user);

		return view('page.admin.blog.index', [
			'user' => $user,
			'blogs' => $blogs,
		]);
	}

	/**
	 * @param Request $request
	 * @param Blog $blog
	 * @return Application|Factory|View
	 * @throws AuthorizationException
	 */
	public function view(Request $request, Blog $blog)
	{
		$this->authorize('view', $blog);

		$blog = $this->blogService->prepareBlogForView($blog);
		$user = $request->user();

		return view('page.admin.blog.view', [
			'blog' => $blog,
			'user' => $user,
		]);
	}

	/**
	 * @param Request $request
	 * @return Application|Factory|View
	 * @throws AuthorizationException
	 */
	public function create(Request $request)
	{
		$this->authorize('create', Blog::class);

		return view('page.admin.blog.create');
	}

	/**
	 * @param StoreBlogRequest $request
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function store(StoreBlogRequest $request)
	{
		$this->authorize('create', Blog::class);

		$validated = $request->validated();

		$blog = $this->blogService->createBlog(
			$request->user(),
			$validated,
			$request->boolean('archived', true),
		);

		return $blog ?
			redirect(route('admin.blog'))->with([
				'create-blog-success' => __('Blog berhasil dibuat'),
				'blog' => $blog->slug,
			]) :
			back()->withErrors([
				'create-blog-failed' => __('Blog gagal dibuat'),
			]);
	}

	/**
	 * @param Request $request
	 * @param Blog $blog
	 * @return Application|Factory|View
	 * @throws AuthorizationException
	 */
	public function edit(Request $request, Blog $blog)
	{
		$this->authorize('update', $blog);

		return view('page.admin.blog.edit', ['blog' => $blog]);
	}

	/**
	 * @param UpdateBlogRequest $request
	 * @param Blog $blog
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function update(UpdateBlogRequest $request, Blog $blog)
	{
		$this->authorize('update', $blog);

		$validated = $request->validated();

		return $this->blogService->updateBlog($blog, $validated) ?
			back()->with(['update-blog-success' => 'Blog berhasil diperbarui']) :
			back()->withErrors(['update-blog-failed' => 'Blog gagal diperbarui']);
	}

	/**
	 * @param Request $request
	 * @param Blog $blog
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function upload(Request $request, Blog $blog)
	{
		$this->authorize('update', $blog);

		return $this->blogService->uploadBlog($blog) ?
			back()->with([
				'upload-blog-success' => __('Blog berhasil diunggah'),
			]) :
			back()->withErrors([
				'upload-blog-failed' => __('Blog gagal diunggah'),
			]);
	}

	/**
	 * @param Request $request
	 * @param Blog $blog
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function delete(Request $request, Blog $blog)
	{
		$this->authorize('delete', $blog);

		if ($this->blogService->delete($blog)) {
			$message = ['delete-blog-success' => 'Berhasil menghapus blog'];

			return $request->routeIs('admin.blog') ?
				back()->with($message) :
				redirect(route('admin.blog'))->with($message);
		}

		return back()->withErrors(['delete-blog-failed' => 'Gagal menghapus blog']);
	}
}
