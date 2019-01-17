<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Queue\SerializesModels;

class VideoHit
{
    use SerializesModels;

    public $video;
    /**
     * Create a new event instance.
     * @param  $video
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
    }
}
