<?php

namespace App\Strategy;

use App\Http\Resources\CourseResource;
use App\Repository\CourseRepository;

class CollegeCourse implements ICollegeContentType
{

	protected $repository;

	public function getContentList($sectionId, $sort, $size)
	{
		$this->repository = new CourseRepository();
		$courses = $this->repository->collegeSectionCourse($sectionId, $sort, $size);
		return CourseResource::collection($courses);
	}
}