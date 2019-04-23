<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CollegeResource extends Resource
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
	        'title'=> $this->title,
	        'sold_on'=> $this->sold_on,
	        'price'=> $this->price,
	        'active_price'=> $this->when($this->in_active, $this->active_price),
	        'brief' => $this->brief,
	        'image' => $this->image,
	        'clicks' => $this->clicks,
	        'contentNums' => $this->content_count,
	        'items' => CollegeSectionResource::collection($this->whenLoaded('section'))
        ];
    }
}
