<?php
/**
 * Created by PhpStorm.
 * User: xiatong
 * Date: 2019/1/16
 * Time: 9:37 AM
 */

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
        return $items = $this->courseService->BackList($limit);
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
        return $this->apiReturn($items);
    }

    public function addSection($course_id,Request $request){
        $param = $request->all();
        $res = $this->courseService->BackAddSection($course_id,$param);
        return $this->apiReturn();

    }
}