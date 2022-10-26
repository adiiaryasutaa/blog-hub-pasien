<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserProfileController extends Controller
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
	 * @return Application|Factory|View
	 */
	public function index()
	{
		return view('page.admin.profile.index', [
			'user' => auth()->user(),
		]);
	}

	/**
	 * @return Application|Factory|View
	 */
	public function edit(Request $request)
	{
		return view('page.admin.profile.edit', [
			'user' => auth()->user(),
		]);
	}

	/**
	 * @param UpdateProfileRequest $request
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function update(UpdateProfileRequest $request)
	{
		$user = $request->user();

		$this->authorize('update', $user);

		$data = $request->validated();

		return $this->userService->updateProfile($user, $data) ?
			back()->with(['update-profile-success' => 'Update profil berhasil']) :
			back()->withErrors(['update-profile-failed' => 'Update profil gagal']);
	}

	/**
	 * @param ChangePasswordRequest $request
	 * @return RedirectResponse
	 * @throws AuthorizationException
	 */
	public function changePassword(ChangePasswordRequest $request)
	{
		$user = $request->user();

		$this->authorize('update', $user);

		$password = $request->validated()['new-password'];

		return $this->userService->changePassword($user, $password) ?
			back()->with(['change-password-success' => 'Ganti password berhasil']) :
			back()->withErrors(['change-password-failed' => 'Ganti password gagal']);
	}
}
