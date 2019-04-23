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
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'is_free'=>$this->is_free,
            'file_id'=>$this->when($this->source_id, $this->source_id),
            'timer'=>$this->when($this->source_id, $this->duration_time),
            'section_num'=>$this->section_num,
            'section'=>self::collection($this->whenLoaded('children')),
        ];
    }
}
