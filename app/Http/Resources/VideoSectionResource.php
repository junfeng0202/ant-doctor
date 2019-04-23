<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VideoSectionResource extends Resource
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return array
	 */
	public function toArray($request)
	{

		return [
			'id' => $this->id,
			'title' => $this->title,
			'clicks' => (int)$this->clicks,
			'is_free' => $this->is_free,
			'audio_url' => $this->when($this->is_free, $this->url),
			'timer' => $this->duration_time,
			'section_num' => $this->section_num
		];
	}
}
