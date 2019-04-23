<?php

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Http\Requests\CourseRequest;
use App\Service\CourseService;
use Illuminate\Http\Request;

class CourseController extends ApiController
{
	protected $courseService;

	public function __construct(CourseService $courseService)
	{
		$this->courseService = $courseService;

	}

	public function list(Request $request)
	{
		$limit = $request->get('limit');
		$kw = $request->all();
		return $this->apiReturn($this->courseService->BackList($limit, $kw));
	}

	public function info($id)
	{
		$item = $this->courseService->BackInfo($id);
		return $this->apiReturn($item);
	}

	public function create(CourseRequest $request)
	{
		$this->courseService->BackUpdateOreCreate($request);
		return $this->apiReturn();
	}

	public function sections(Request $request, $id)
	{
		$items = $this->courseService->BackSections($request, $id);
		return $this->apiReturn($items);
	}

	public function addSection(Request $request,$id)
	{
		$param = $request->all();
		$this->courseService->BackAddSection($id, $param);
		return $this->apiReturn();

	}
}