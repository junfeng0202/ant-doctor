<?php
/**
 * Created by PhpStorm.
 * User: xiatong
 * Date: 2019/1/16
 * Time: 9:37 AM
 */

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Service\ArticleService;
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
        $res = $this->liveService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }
}