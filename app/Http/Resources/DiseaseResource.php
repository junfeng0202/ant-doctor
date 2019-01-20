<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiseaseResource extends JsonResource
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
		    'id'=> $this->id,
		    'disease_name'=>$this->name,
		    'parent_id'=>$this->when($this->pid,$this->pid),
	    ];
    }
}
