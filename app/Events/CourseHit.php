<?php

namespace App\Events;

use App\Models\Course;
use Illuminate\Queue\SerializesModels;

class CourseHit
{
    use SerializesModels;

    public $course;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
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
