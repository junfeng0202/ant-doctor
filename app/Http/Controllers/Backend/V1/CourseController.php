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
    public function list(Request $request){
        $limit = $request->get('limit');
        return $items =  $this->courseService->BackList($limit);
        return $this->apiReturn($items);

    }
}