<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FeedbackResource extends Resource
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
	        'type'=> $this->type,
	        'member'=> $this->member,
	        'desc' => $this->content,
	        'images' => FeedbackImageResource::collection($this->images),
	        'created_at' => $this->created_at
        ];
    }
}
