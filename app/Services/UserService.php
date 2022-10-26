<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
	/**
	 * @param $data
	 * @return bool
	 */
	public function register($data);

	/**
	 * @param array $credentials
	 * @param bool $remember
	 * @return bool
	 */
	public function login($credentials, $remember);

	/**
	 * @return void
	 */
	public function out();

	/**
	 * @param User $user
	 * @param $data
	 * @return User|bool
	 */
	public function updateProfile(User $user, $data);

	/**
	 * @param User $User
	 * @param $password
	 * @return bool
	 */
	public function changePassword(User $User, $password);

	/**
	 * @param User $User
	 * @return bool
	 */
	public function delete(User $User);
}
