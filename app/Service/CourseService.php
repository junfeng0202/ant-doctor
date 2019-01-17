<?php

namespace App\Service;

use App\Http\Resources\CourseResource;
use App\Repository\CourseRepository;

class CourseService extends Service
{
	protected $courseRepository;


	public function __construct(CourseRepository $courseRepository)
	{
		$this->courseRepository = $courseRepository;
	}


	public function index()
	{
		$items = $this->courseRepository->paginate();
		return CourseResource::collection($items);
	}

	public function info($id)
	{
		$item = $this->courseRepository->getById($id);
		return new CourseResource($item);
	}

	public function BackList($limit){
	    $items = $this->courseRepository->paginate($limit);
//	    dd($items->toArray());
        return CourseResource::collection($items);
	}

}