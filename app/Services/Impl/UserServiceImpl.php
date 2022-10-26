<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\UserService;
use Exception;
use Hash;
use Throwable;

class UserServiceImpl implements UserService
{
	/**
	 * @inheritDoc
	 */
	public function register($data = [])
	{
		return false;
		try {
			$data['password'] = Hash::make($data['password']);

			return User::create($data);
		} catch (Throwable $e) {
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function login($credentials = [], $remember = false)
	{
		return auth()->attempt($credentials, $remember);
	}

	/**
	 * @inheritDoc
	 */
	public function out()
	{
		auth()->logout();
	}

	/**
	 * @inheritDoc
	 */
	public function updateProfile(User $user, $data = [])
	{
		try {
			foreach ($data as $key => $value) {
				if (is_null($value))
					unset($data[$key]);
			}

			throw_if(!$user->updateOrFail($data), Exception::class, 'Update failed');

			return User::find($user->id);
		} catch (Throwable $e) {
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function changePassword(User $User, $password)
	{
		try {
			return $User->updateOrFail(['password' => Hash::make($password)]);
		} catch (Throwable $e) {
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function delete(User $User)
	{
		try {
			return $User->delete();
		} catch (Throwable $e) {
			return false;
		}
	}
}
