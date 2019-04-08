<?php

namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Service\VideoService;
use Illuminate\Http\Request;

class AudioController extends ApiController
{
    protected $audioService;

    public function __construct(VideoService $audioService)
    {
        $this->audioService = $audioService;

    }

    public function list(Request $request)
    {
        $limit = $request->get('limit');
        $kw = $request->all();
        $res =  $items = $this->audioService->BackList($limit,$kw);
        return $this->apiReturn($res);
    }

    public function info($id)
    {
        $item = $this->audioService->BackInfo($id);
        return $this->apiReturn($item);
    }

    public function create(Request $request)
    {
        $param = $request->all();
        $res = $this->audioService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }

    public function sections($id)
    {
        $items = $this->audioService->BackSections($id);
        return $this->apiReturn($items);
    }

    public function addSection($audio,Request $request){
        $param = $request->all();
        $res = $this->audioService->BackAddSection($audio,$param);
        return $this->apiReturn();

    }
}