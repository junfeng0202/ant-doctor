<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
	        'id' =>$this->id,
	        'title' => $this->title,
	        'status'=>$this->getStatus($this->status),
	        'image' =>$this->image,
	        'brief' =>$this->when(!$this->index,$this->brief),
	        'start_time' =>$this->start_at->format('n/j H:i'),
	        'end_time' =>$this->end_at->format('n/j H:i'),
	        'live_url'=>$this->when(!$this->index,$this->link),
	        'disease'=> $this->whenLoaded('disease'),
        ];
    }
}
