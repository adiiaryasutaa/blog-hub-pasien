<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ManageUserPolicy
{
	use HandlesAuthorization;

	/**
	 * Create a new policy instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * @param User $user
	 * @return Response
	 */
	public function view(User $user)
	{
		return $this->allow();
	}

	/**
	 * @param User $user
	 * @return Response
	 */
	public function create(User $user)
	{
		return $user->isOwner() ?
			$this->allow() : $this->denyAsNotFound();
	}

	/**
	 * @param User $user
	 * @return Response
	 */
	public function attachRole(User $user)
	{
		return $this->create($user);
	}

	/**
	 * @param User $user
	 * @param User $target
	 * @return Response
	 */
	public function update(User $user, User $target)
	{
		// A user wants to update itself
		if ($user->isOwner() || $user->is($target))
			return $this->allow();

		// An admin wants to update a normal user
		if ($user->isAdmin() && $target->isNormal())
			return $this->allow();

		// An admin wants to update an owner and other admins
		// A normal user wants to update other normal users
		return $this->denyAsNotFound();
	}

	/**
	 * @param User $user
	 * @param User $target
	 * @return Response
	 */
	public function changePassword(User $user, User $target)
	{
		return $this->update($user, $target);
	}

	/**
	 * @param User $user
	 * @param User $target
	 * @return Response
	 */
	public function delete(User $user, User $target)
	{
		return $user->isOwner() && !$target->isOwner() ?
			$this->allow() : $this->denyAsNotFound();
	}
}
