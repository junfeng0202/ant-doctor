<?php

namespace App\Listeners;

use App\Events\CollegeHit;
use Illuminate\Support\Facades\Redis;

class CollegeHitListener
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Handle the event.
	 *
	 * @param  CollegeHit $event
	 * @return void
	 */
	public function handle(CollegeHit $event)
	{
		Redis::hincrby(config('redisKeys.collegeHits'), $event->college_id, 1);
	}
}
