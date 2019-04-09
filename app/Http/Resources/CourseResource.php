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
            'havesection' => (string)$this->havesection,
            'enable' => (string)$this->enable,
        	'clicks'=>(int)$this->clicks,
            'disease_id' =>$this->whenLoaded('disease',function(){
                return $this->disease->id;
            }),
        	'disease'=>$this->whenLoaded('disease',function(){
        		return $this->disease->name;
	        }),
            'doctor_ids' =>$this->whenLoaded('doctor',function(){
                $ids = [];
                foreach ($this->doctor as $v){
                    $ids[] = $v->id;
                }

                return $ids;
            }),
            'doctor'=>$this->whenLoaded('doctor',function(){
                $name = [];
                foreach ($this->doctor as $v){
                    $name[] = $v->name;
                }

                return implode('，',$name);
            }),
            'sort'=>(int)$this->sort,
        	'image'=>$this->image,
        	'brief'=>$this->when(!$this->index, $this->brief),
	        'count'=>$this->audio_count,
	        'timer'=>$this->whenLoaded('section',function(){
				return $this->section()->where('source_id','<>','')->value('duration') ?? '00:00:00';
	        }),
	        'chapters'=>$this->when($this->chapters,$this->chapters),
        	'created_at'=>$this->when($this->created_at, $this->created_at->format('Y-m-d')),
	        'link'=>route('course.info',['id'=>$this->id])
        ];
    }
}
