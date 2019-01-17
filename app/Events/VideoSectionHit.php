<?php

namespace App\Events;

use App\Models\VideoSection;
use Illuminate\Queue\SerializesModels;

class VideoSectionHit
{
    use SerializesModels;

    public $videoSection;
    /**
     * Create a new event instance.
     * @param $videoSection
     * @return void
     */
    public function __construct(VideoSection $videoSection)
    {
        $this->videoSection = $videoSection;
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
