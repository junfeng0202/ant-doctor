<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VideoResource extends Resource
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
        	'id'=>$this->id,
        	'title'=>$this->title,
        	'clicks'=>(int)$this->clicks,
        	'disease'=>$this->whenLoaded('disease',function(){
        		return $this->disease->name;
	        }),
	        'doctor'=>$this->whenLoaded('doctor'),
        	'brief'=>$this->when(!$this->index,$this->brief),
        	'image'=>$this->image,
	        'price' => $this->price,
	        'active_price' => $this->when($this->in_active, $this->active_price),
	        'section'=>VideoSectionResource::collection($this->whenLoaded('section'))
        ];
    }
}
