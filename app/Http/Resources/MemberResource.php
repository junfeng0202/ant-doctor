<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
        	'username'=>$this->phone,
        	'avatar'=>$this->avatar,
        	'nickname'=>$this->nickname,
        	'identify'=>$this->identify,
        	'birthday'=>$this->birth,
        	'diagnosis'=>$this->diagnosis_at,
        	'province'=>$this->province_id,
        	'city'=>$this->city_id,
        	'gender'=>$this->gender,
        	'company'=>$this->company,
        	'interest'=>DiseaseResource::collection($this->interest),
        	'combine'=>DiseaseResource::collection($this->combine),
        	'complication'=>DiseaseResource::collection($this->complication),
        ];
    }
}
