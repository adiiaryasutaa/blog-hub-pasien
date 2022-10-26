<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Blog;
use App\Models\User;
use App\Policies\BlogPolicy;
use App\Policies\ManageUserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The model to policy mappings for the application.
	 *
	 * @var array<class-string, class-string>
	 */
	protected $policies = [
		User::class => ManageUserPolicy::class,
		Blog::class => BlogPolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();

		//
	}
}
