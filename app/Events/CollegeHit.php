<?php

namespace App\Events;

use App\Models\College;
use Illuminate\Queue\SerializesModels;

class CollegeHit
{
    use SerializesModels;

	public $college_id;


	/**
	 * CollegeHit constructor.
	 * @param College $college
	 */
	public function __construct($id)
    {
	    $this->college_id = $id;
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
