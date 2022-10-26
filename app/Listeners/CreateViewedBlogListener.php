<?php

namespace App\Listeners;

use App\Events\BlogViewed;
use App\Models\ViewedBlog;

class CreateViewedBlogListener
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param BlogViewed $event
	 * @return void
	 */
	public function handle(BlogViewed $event)
	{
		$event->blog->views()->create();
	}
}
