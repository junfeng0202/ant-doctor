<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\ArticleService;
use App\Service\CourseService;

class CourseController extends ApiController
{
	protected $courseService;

	public function __construct(CourseService $courseService)
	{
		$this->courseService = $courseService;

	}

	public function index()
	{
		$data = $this->courseService->index();
		return $this->apiReturn($data);
	}

	public function info($id)
	{
		return $this->apiReturn($this->courseService->info($id));
	}



}
