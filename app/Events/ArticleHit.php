<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Queue\SerializesModels;

class ArticleHit
{
    use SerializesModels;

    public $article;
    /**
     * Create a new event instance.
     * @param $article
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
       // return new PrivateChannel('channel-name');
    }
}
