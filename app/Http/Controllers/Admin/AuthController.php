<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
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
	public function login(Request $request)
	{
		return view('page.admin.auth.login');
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function authenticate(Request $request)
	{
		$credentials = $request->only(['username', 'password']);
		$remember = $request->boolean('remember');

		if ($this->userService->login($credentials, $remember)) {
			session()->regenerate();
			return redirect()->intended(route('admin.dashboard'));
		}

		return back()->withErrors(['login-failed' => __('Login gagal')]);
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function logout(Request $request)
	{
		$this->userService->out();

		return redirect()->route('admin.auth');
	}
}
