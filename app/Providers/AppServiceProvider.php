<?php

namespace App\Providers;

use App\Services\UserService;
use App\Services\BlogService;
use App\Services\Impl\UserServiceImpl;
use App\Services\Impl\BlogServiceImpl;
use App\Services\Impl\TrashServiceImpl;
use App\Services\TrashService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register(): void
	{
		$this->app->singleton(UserService::class, fn() => new UserServiceImpl());
		$this->app->singleton(BlogService::class, fn() => new BlogServiceImpl());
		$this->app->singleton(TrashService::class, fn() => new TrashServiceImpl());

		Arr::macro('unsetIfNullOrEmpty', function ($array) {
			foreach ($array as $key => $value) {
				if (is_null($value) || (is_string($value) && str($value)->isEmpty())) {
					unset($array[$key]);
				}
			}

			return $array;
		});
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot(): void
	{
		//
	}
}
