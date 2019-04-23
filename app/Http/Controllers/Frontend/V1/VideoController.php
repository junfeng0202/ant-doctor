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

	public function index(Request $request)
	{
		$data = $this->videoService->paginate($request);
		return $this->apiReturn($data);
	}

	public function info($id)
	{
		$item = $this->videoService->info($id);
		return $this->apiReturn($item);
	}

	public function section($id)
	{
		$item = $this->videoService->section($id);
		return $this->apiReturn($item);
	}


}
