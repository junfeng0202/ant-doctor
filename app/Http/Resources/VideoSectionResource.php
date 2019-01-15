<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VideoSectionResource extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return $this->map(function(){
        	return [
        		'id'=>$this->id,
        		'title'=>$this->title,
        		'audio_url'=>$this->url,
        		'timer'=>$this->duration,
        		'created_at'=>(string)$this->created_at,
	        ];
       // });
    }
}
