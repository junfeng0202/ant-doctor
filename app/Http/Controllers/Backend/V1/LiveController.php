<?php
namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Service\LiveService;
use Illuminate\Http\Request;

class LiveController extends ApiController
{
    protected $liveService;

    public function __construct(LiveService $liveService)
    {
        $this->liveService = $liveService;

    }

    public function list(Request $request)
    {
        $limit = $request->get('limit');
        $kw = $request->all();
        $res =  $items = $this->liveService->BackList($limit,$kw);
        return $this->apiReturn($res);
    }

    public function info($id)
    {
        $item = $this->liveService->BackInfo($id);
        return $this->apiReturn($item);
    }

    public function create(Request $request)
    {
        $param = $request->all();
        $this->liveService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }

    public function delete($id){
        $res = $this->liveService->delete($id);
        return $this->apiReturn($res);
    }
}