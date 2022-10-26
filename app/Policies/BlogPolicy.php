<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BlogPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any models.
	 *
	 * @param User $user
	 * @return Response
	 */
	public function viewAny(User $user)
	{
		return $this->allow();
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param User $user
	 * @param Blog $blog
	 * @return Response
	 */
	public function view(User $user, Blog $blog)
	{
		return $this->allow();
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param User $user
	 * @return Response
	 */
	public function create(User $user)
	{
		return $this->allow();
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param User $user
	 * @param Blog $blog
	 * @return Response
	 */
	public function update(User $user, Blog $blog)
	{
		return $user->isOwner() || ($user->isAdmin() && !$blog->author->isOwner()) || $blog->author()->is($user) ?
			$this->allow() : $this->denyAsNotFound();
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param User $user
	 * @param Blog $blog
	 * @return Response
	 */
	public function delete(User $user, Blog $blog)
	{
		return $this->update($user, $blog);
	}

	/**
	 * @param User $user
	 * @return Response
	 */
	public function viewAnyTrash(User $user)
	{
		return $this->allow();
	}

	public function viewTrash(User $user, Blog $blog)
	{
		return $blog->author->is($user) ?
			$this->allow() : $this->denyAsNotFound();
	}

	/**
	 * Determine whether the user can restore the model.
	 *
	 * @param User $user
	 * @param Blog $blog
	 * @return Response
	 */
	public function restore(User $user, Blog $blog)
	{
		return $this->viewTrash($user, $blog);
	}

	/**
	 * @param User $user
	 * @return Response
	 */
	public function restoreAll(User $user)
	{
		return $this->allow();
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 *
	 * @param User $user
	 * @param Blog $blog
	 * @return Response
	 */
	public function forceDelete(User $user, Blog $blog)
	{
		return $this->viewTrash($user, $blog);
	}

	/**
	 * @param User $user
	 * @return Response
	 */
	public function forceDeleteAll(User $user)
	{
		return $this->allow();
	}
}
