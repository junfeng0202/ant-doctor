<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\VideoService;
use Illuminate\Http\Request;

class VideoController extends ApiController
{
	protected $videoService;

	public function __construct(VideoService $videoService)
	{
		$this->videoService = $videoService;

	}

	/**
	 * 音频列表
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(Request $request)
	{
		$data = $this->videoService->paginate($request);
		return $this->apiReturn($data);
	}

	/**
	 * 音频详情
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function info($id)
	{
		$item = $this->videoService->info($id);
		return $this->apiReturn($item);
	}

	/**
	 * 音频小节
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function section($id)
	{
		$item = $this->videoService->section($id);
		return $this->apiReturn($item);
	}


}
