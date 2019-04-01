<?php

namespace App\Strategy;

use App\Http\Resources\VideoResource;
use App\Repository\VideoRepository;

class CollegeVideo implements ICollegeContentType
{

	protected $repository;

	public function getContentList($sectionId, $sort, $size)
	{
		$this->repository = new VideoRepository();
		$videos = $this->repository->collegeSectionVideo($sectionId,  $sort, $size);
		return VideoResource::collection($videos);
	}
}