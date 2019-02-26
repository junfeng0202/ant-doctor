<?php

namespace App\Listeners;

use App\Events\VideoSectionHit;
use Illuminate\Support\Facades\Redis;

class VideoSectionHitListener
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
     * @param  VideoSectionHit  $event
     * @return void
     */
    public function handle(VideoSectionHit $event)
    {
	    Redis::hincrby(config('redisKeys.videoSectionHits'),$event->videoSection->id,1);
    }
}
