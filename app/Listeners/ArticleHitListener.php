<?php

namespace App\Listeners;

use App\Events\ArticleHit;
use Illuminate\Support\Facades\Redis;

class ArticleHitListener
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
     * @param  ArticleHit  $event
     * @return void
     */
    public function handle(ArticleHit $event)
    {
	    Redis::hincrby('qqq','aaa',1);
	    Redis::hincrby(config('redisKeys.articleHits'),$event->article->id,1);
    }
}
