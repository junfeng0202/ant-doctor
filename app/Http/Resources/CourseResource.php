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
            'multiSection' => $this->havesection,
        	'clicks'=>(int)$this->clicks,
            'doctor'=>$this->whenLoaded('doctor',function(){
                return implode('，',$this->doctor->pluck('name')->toArray());
            }),
	        'price' => $this->price,
	        'active_price' => $this->when($this->in_active, $this->active_price),
        	'image'=>$this->image,
	        'buyStatus'=> $this->when(isset($this->buyStatus), $this->buyStatus),
        	'brief'=>$this->when(!$this->index, $this->brief),
	        'count'=>$this->audio_count,
	        'timer'=>$this->whenLoaded('section',function(){
	        	$section = $this->section()->where('source_id','<>','')->first();
				return $section ? $section->duration_time : '00:00';
	        }),
	        'chapters'=>$this->when($this->chapters,$this->chapters)
        ];
    }
}
