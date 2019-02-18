<?php
/**
 * Created by PhpStorm.
 * User: xiatong
 * Date: 2019/1/16
 * Time: 9:37 AM
 */

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Service\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends ApiController
{
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;

    }

    public function list(Request $request)
    {
        $limit = $request->get('limit');
        $kw = $request->all();
        $res =  $items = $this->doctorService->BackList($limit,$kw);
        return $this->apiReturn($res);
    }

    public function info($id)
    {
        $item = $this->doctorService->BackInfo($id);
        return $this->apiReturn($item);
    }

    public function create(Request $request)
    {
        $param = $request->all();
        $res = $this->doctorService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }
}