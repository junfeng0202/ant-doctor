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

        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'clicks'=>(int)$this->clicks,
            //'audio_url'=>$this->url,
            'timer'=>$this->duration,
            'created_at'=>(string)$this->created_at,
	        'link'=>route('video.section',['id'=>$this->id])
        ];
    }
}
