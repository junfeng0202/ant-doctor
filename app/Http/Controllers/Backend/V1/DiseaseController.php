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
        $disease = $this->diseaseService->BackUpdateOreCreate($param);
        $res = [
        	'id'=>(string)$disease->id,
	        'pid'=>(string)$disease->pid,
	        'name'=>$disease->name,
	        'children'=>[]
        ];
        return $this->apiReturn($res);
    }
    public function delete($id){
        $res = $this->diseaseService->delete($id);
        return $this->apiReturn($res);
    }
}