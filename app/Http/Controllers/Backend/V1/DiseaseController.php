<?php
/**
 * Created by PhpStorm.
 * User: xiatong
 * Date: 2019/1/16
 * Time: 9:37 AM
 */

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Service\DiseaseService;
use Illuminate\Http\Request;

class DiseaseController extends ApiController
{
    protected $diseaseService;

    public function __construct(DiseaseService $diseaseService)
    {
        $this->diseaseService = $diseaseService;

    }

    public function listTree()
    {
        $res = $this->diseaseService->BackListTree();
        return $this->apiReturn($res);
    }

    public function save(Request $request)
    {
        $param = $request->all();
        $res = $this->diseaseService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }
    public function delete($id){
        $res = $this->diseaseService->delete($id);
        return $this->apiReturn($res);
    }
}