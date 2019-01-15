<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CourseResource extends Resource
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
        	'image'=>$this->image,
	        'count'=>$this->section_count,
	        'timer'=>$this->whenLoaded('section',function(){
				return $this->section()->where('source_id','<>','')->value('duration');
	        }),
        	'created_at'=>(string)$this->created_at,
        ];
    }
}
