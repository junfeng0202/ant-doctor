<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveResource extends JsonResource
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
	        'live_id' =>$this->id,
	        'liveTitle' => $this->title,
	        'liveImg' =>$this->image,
	        'brief' =>$this->when(!$this->isIndex,$this->brief),
	        'liveStartDate' =>(string)$this->start_at,
	        'liveEndDate' =>(string)$this->end_at,
	        'link'=>route('live.info',['id'=>$this->id])
        ];
    }
}
