<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\StudyLogRequest;
use App\Service\CourseService;
use Illuminate\Http\Request;

class CourseController extends ApiController
{
	protected $courseService;

	public function __construct(CourseService $courseService)
	{
		$this->courseService = $courseService;

	}

	public function index(Request $request)
	{
		$data = $this->courseService->index($request);
		return $this->apiReturn($data);
	}

	public function info($id)
	{
		return $this->apiReturn($this->courseService->info($id));
	}

	public function audio($id)
	{
		return $this->apiReturn($this->courseService->audio($id));
	}

	public function study(StudyLogRequest $request)
	{
		$this->courseService->study($request);
		return $this->apiReturn();
	}


}
