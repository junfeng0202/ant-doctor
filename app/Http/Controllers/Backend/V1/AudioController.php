<?php

namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\VideoRequest;
use App\Service\VideoService;
use Illuminate\Http\Request;

class AudioController extends ApiController
{
    protected $audioService;

    public function __construct(VideoService $videoService)
    {
        $this->audioService = $videoService;

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

    public function create(VideoRequest $request)
    {
        $param = $request->all();
        $this->audioService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }

	/**
	 * 小节列表
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sections(Request $request, $id)
    {
        $items = $this->audioService->BackSections($id, $request);
        return $this->apiReturn($items);
    }

    public function addSection(Request $request, $audio){
        $this->audioService->BackAddSection($audio,$request);
        return $this->apiReturn();

    }
}