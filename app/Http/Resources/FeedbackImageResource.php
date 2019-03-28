<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FeedbackImageResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        	'id'   => $this->id,
	        'url' => $this->image,
        ];
    }
}
