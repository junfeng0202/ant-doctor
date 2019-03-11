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
	        'id'     => $this->id,
	        'title'  => $this->title,
	        'disease'=>$this->whenLoaded('disease',function(){
		        return $this->disease->name;
	        }),
	        'image'  => $this->image,
	        'clicks' => (int)$this->clicks,
	        'content'=> $this->when(!$this->index, $this->content),
	        'link'   => route('article.info',['id'=>$this->id])
        ];
    }
}
