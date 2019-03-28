<?php

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
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
        return $this->apiReturn($this->courseService->BackList($limit,$kw));
    }

    public function info($id)
    {
        $item = $this->courseService->BackInfo($id);
        return $this->apiReturn($item);
    }

    public function create(Request $request)
    {
        $param = $request->all();
        $res = $this->courseService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }

    public function sections($id)
    {
        $items = $this->courseService->BackSections($id);
//        dd($items);
        return $this->apiReturn($items);
    }

    public function addSection($course_id,Request $request){
        $param = $request->all();
        $res = $this->courseService->BackAddSection($course_id,$param);
        return $this->apiReturn();

    }
}