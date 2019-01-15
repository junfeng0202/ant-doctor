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
        	'hits'=>$this->hits,
        	'disease'=>$this->whenLoaded('disease',function(){
        		return $this->disease->name;
	        }),
        	'brief'=>$this->brief,
        	'image'=>$this->image,
        	'created_at'=>(string)$this->created_at,
        ];
    }
}
