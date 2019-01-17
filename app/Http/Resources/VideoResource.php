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
        	'brief'=>$this->when(!$this->index,$this->brief),
        	'image'=>$this->image,
	        'section'=>VideoSectionResource::collection($this->whenLoaded('section')),
        	'created_at'=>(string)$this->created_at,
        	'link'=>route('video.info',['id'=>$this->id]),
        ];
    }
}
