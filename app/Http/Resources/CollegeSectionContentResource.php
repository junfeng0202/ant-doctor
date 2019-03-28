<?php

namespace App\Http\Resources;

use App\Models\CollegeSection;
use Illuminate\Http\Resources\Json\Resource;

class CollegeSectionContentResource extends Resource
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
        	'id'   => $this->id,
        	'sort'   => $this->sort,
	        $this->mergeWhen($this->contentable_type == CollegeSection::COURSE, [
		        'content' => new CourseResource($this->whenLoaded('contentable')),
	        ]),
	        $this->mergeWhen($this->contentable_type == CollegeSection::VIDEO, [
		        'content' => new CourseResource($this->whenLoaded('contentable')),
	        ]),
	        $this->mergeWhen($this->contentable_type == CollegeSection::ARTICLE, [
		        'content' => new ArticleResource($this->whenLoaded('contentable')),
	        ]),
        ];
    }
}
