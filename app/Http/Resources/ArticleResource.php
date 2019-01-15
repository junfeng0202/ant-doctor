<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
	        'article_id' =>$this->id,
	        'infoTitle' => $this->title,
	        'infoImg' =>$this->image,
	        'infoCount' =>$this->hits
        ];
    }
}
