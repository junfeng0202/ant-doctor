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

	/**
	 * 课程列表
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(Request $request)
	{
		$data = $this->courseService->index($request);
		return $this->apiReturn($data);
	}

	/**
	 * 课程详情
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function info($id)
	{
		return $this->apiReturn($this->courseService->info($id));
	}

	/**
	 * 课程下面的视频信息
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function audio($id)
	{
		return $this->apiReturn($this->courseService->audio($id));
	}

	/**
	 * 学习记录
	 * @param StudyLogRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function study(StudyLogRequest $request)
	{
		$this->courseService->study($request);
		return $this->apiReturn();
	}


}
