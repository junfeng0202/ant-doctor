<?php

namespace App\Listeners;

use App\Events\VideoHit;
use Illuminate\Support\Facades\Redis;

class VideoHitListener
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
     * @param  VideoHit  $event
     * @return void
     */
    public function handle(VideoHit $event)
    {
        Redis::hincrby(config('redisKeys.videoHits'),$event->video->id,1);
    }
}
