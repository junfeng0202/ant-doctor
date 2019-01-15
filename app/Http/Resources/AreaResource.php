<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        	'id'=>$this->id,
	        'parent_id '=>$this->pid,
	        'name'=>$this->name,
	        'city'=>self::collection($this->whenLoaded('children'))
        ];
    }
}
