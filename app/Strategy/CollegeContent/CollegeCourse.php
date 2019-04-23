<?php

namespace App\Strategy\CollegeContent;

use App\Http\Resources\CourseResource;
use App\Repository\CourseRepository;

class CollegeCourse implements ICollegeContent
{

	protected $repository;

	public function getContentList($sectionId, $sort, $size)
	{
		$this->repository = new CourseRepository();
		$courses = $this->repository->collegeSectionCourse($sectionId, $sort, $size);
		return CourseResource::collection($courses);
	}
}