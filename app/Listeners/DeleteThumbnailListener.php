<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Storage;

class DeleteThumbnailListener
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
	 * @param object $event
	 * @return void
	 */
	public function handle($event)
	{
		Storage::disk('public')
			->delete("blog/thumbnail/{$event->blog->thumbail}");
	}
}
