<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CollegeSectionResource extends Resource
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
	        'sort' => $this->sort,
	        'enable' => $this->enable,
	        'type' => $this->type,
	        'total' => $this->when($this->total, $this->total),
	        'content' => CollegeSectionContentResource::collection($this->whenLoaded('content'))
        ];
    }
}
