<?php

namespace App\Listeners;

use App\Events\CourseHit;
use Illuminate\Support\Facades\Redis;

class CourseHitListener
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
     * @param  CourseHit  $event
     * @return void
     */
    public function handle(CourseHit $event)
    {
	    Redis::hincrby(config('redisKeys.courseHits'),$event->course->id,1);
    }
}
