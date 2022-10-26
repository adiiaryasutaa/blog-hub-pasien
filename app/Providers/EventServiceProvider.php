<?php

namespace App\Providers;

use App\Events\BlogDeleted;
use App\Events\BlogViewed;
use App\Listeners\CreateViewedBlogListener;
use App\Listeners\DeleteThumbnailListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event to listener mappings for the application.
	 *
	 * @var array<class-string, array<int, class-string>>
	 */
	protected $listen = [
		BlogViewed::class => [
			CreateViewedBlogListener::class,
		],

		BlogDeleted::class => [
			DeleteThumbnailListener::class,
		],
	];

	/**
	 * Register any events for your application.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Determine if events and listeners should be automatically discovered.
	 *
	 * @return bool
	 */
	public function shouldDiscoverEvents()
	{
		return false;
	}
}
