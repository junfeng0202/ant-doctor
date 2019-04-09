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
        	'enable'=>$this->enable,
        	'clicks'=>(int)$this->clicks,
        	'disease'=>$this->whenLoaded('disease',function(){
        		return $this->disease->name;
	        }),
	        'doctor'=>$this->whenLoaded('doctor'),
        	'brief'=>$this->when(!$this->index,$this->brief),
        	'image'=>$this->image,
	        'section'=>VideoSectionResource::collection($this->whenLoaded('section')),
        	'created_at'=>$this->when($this->created_at, $this->created_at->format('Y-m-d')),
        	'link'=>route('video.info',['id'=>$this->id]),
        ];
    }
}
