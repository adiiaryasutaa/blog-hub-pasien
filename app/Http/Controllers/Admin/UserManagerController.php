<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeUserPasswordRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserManagerController extends Controller
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
	 * @throws AuthorizationException
	 */
	public function index(Request $request)
	{
		$this->authorize('view', $request->user());

		return view('page.admin.manager.index', [
			'users' => User::withCount('blogs')->orderBy('role')->get(),
		]);
	}

	/**
	 * @param Request $request
	 * @param User $user
	 * @return Application|Factory|View|RedirectResponse|Redirector
	 * @throws AuthorizationException
	 */
	public function profile(Request $request, User $user)
	{
		$this->authorize('view', $request->user());

		if (auth()->user()->is($user))
			return redirect(route('admin.profile'));

		return view('page.admin.profile.index', [
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
		$this->authorize('create', $request->user());

		return view('page.admin.manager.create');
	}

	/**
	 * @param CreateUserRequest $request
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function store(CreateUserRequest $request)
	{
		$this->authorize('create', $request->user());

		$data = $request->validated();

		return $this->userService->register($data) ?
			redirect()->intended(route('manager.user'))->with(['create-user-success' => __('User berhasil didaftarkan')]) :
			back()->withErrors(['create-user-failed' => __('Gagal mendaftarkan user')])->withInput($request->all());
	}

	/**
	 * @param Request $request
	 * @param User $user
	 * @return Application|Factory|RedirectResponse|View
	 * @throws AuthorizationException
	 */
	public function edit(Request $request, User $user)
	{
		$this->authorize('update', $user);

		if (auth()->user()->is($user))
			return redirect()->route('admin.profile.edit');

		return view('page.admin.manager.edit', [
			'user' => $user,
		]);
	}

	/**
	 * @param UpdateUserRequest $request
	 * @param User $user
	 * @return Application|RedirectResponse|Redirector
	 * @throws AuthorizationException
	 */
	public function update(UpdateUserRequest $request, User $user)
	{
		$this->authorize('update', $user);

		$data = $request->validated();

		$user = $this->userService->updateProfile($user, $data);

		return $user ?
			redirect(route('manager.user.edit', ['user' => $user]))
				->with(['update-user-profile-success' => __('Update profil berhasil')])
			:
			back()
				->withErrors(['update-user-profile-failed' => __('Update profil gagal')]);
	}

	/**
	 * @param ChangeUserPasswordRequest $request
	 * @param User $user
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function changePassword(ChangeUserPasswordRequest $request, User $user)
	{
		$this->authorize('update', $user);

		['new-password' => $password] = $request->validated();

		return $this->userService->changePassword($user, $password) ?
			back()->with(['change-user-password-success' => __('Ganti password user berhasil')]) :
			back()->withErrors(['change-user-password-failed' => __('Ganti password user gagal')]);
	}

	/**
	 * @param Request $request
	 * @param User $user
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function destroy(Request $request, User $user)
	{
		$this->authorize('delete', $user);

		return $this->userService->delete($user) ?
			back()->with(['delete-user-success' => 'User berhasil dihapus']) :
			back()->withErrors(['delete-user-failed' => 'User gagal dihapus']);
	}
}
