<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\TrashService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogTrashController extends Controller
{
	private TrashService $trashService;

	/**
	 * @param TrashService $trashService
	 */
	public function __construct(TrashService $trashService)
	{
		$this->trashService = $trashService;
	}

	/**
	 * @param Request $request
	 * @return Application|Factory|View
	 * @throws AuthorizationException
	 */
	public function viewAny(Request $request)
	{
		$this->authorize('viewAny-trash', Blog::class);

		$user = auth()->user();
		$blogs = $this->trashService->getAllTrashedBlogs($user)->get();

		return view('page.admin.trash.index', [
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
		$this->authorize('view-trash', $blog);

		$blog = $this->trashService->prepareBlogForView($blog);

		return view('page.admin.trash.view', ['blog' => $blog]);
	}

	/**
	 * @param Request $request
	 * @param Blog $blog
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function restore(Request $request, Blog $blog)
	{
		$this->authorize('restore', $blog);

		if ($this->trashService->restoreBlog($blog)) {
			$message = ['restore-blog-success' => __('Blog berhasil dikembalikan')];

			return $request->routeIs('admin.blog.trash') ?
				back()->with($message) :
				redirect(route('admin.blog.trash'))->with($message);
		}

		return back()->withErrors(['restore-blog-failed' => __('Blog gagal dikembalikan')]);
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function restoreAll(Request $request)
	{
		$this->authorize('restoreAll', Blog::class);

		return $this->trashService->restoreAllBlogs($request->user()) ?
			back()->with(['restore-all-blog-success' => __('Semua blog berhasil dikembalikan')]) :
			back()->withErrors(['restore-all-blog-failed' => __('Blog gagal dikembalikan')]);
	}

	/**
	 * @param Request $request
	 * @param Blog $blog
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function forceDelete(Request $request, Blog $blog)
	{
		$this->authorize('forceDelete', $blog);

		if ($this->trashService->forceDeleteBlog($blog)) {
			$message = ['delete-blog-success' => __('Blog berhasil dihapus secara permanen')];

			return $request->routeIs('admin.blog.trash') ?
				back()->with($message) :
				redirect(route('admin.blog.trash'))->with($message);
		}

		return back()->withErrors(['delete-blog-failed' => __('Blog gagal dihapus')]);
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function forceDeleteAll(Request $request)
	{
		$this->authorize('forceDeleteAll', Blog::class);

		return $this->trashService->forceDeleteAllBlogs($request->user()) ?
			back()->with(['force-delete-all-blog-success' => __('Semua blog berhasil dihapus')]) :
			back()->withErrors(['force-delete-all-blog-failed' => __('Blog gagal dihapus')]);
	}
}
