<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CourseSectionResource extends Resource
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
        		'audio_id'=>$this->source_id,
        		'timer'=>$this->duration,
        		'section'=>$this->whenLoaded('children'),
	        ];
       // });
    }
}
