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
	        'brief' => $this->brief,
	        'sort' => $this->sort,
	        'image' => $this->image,
	        'enable' => $this->enable,
	        'clicks' => $this->clicks,
	        'items' => $this->whenLoaded('section')
        ];
    }
}
