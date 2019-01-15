<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\VideoService;

class VideoController extends ApiController
{
	protected $videoService;

	public function __construct(VideoService $videoService)
	{
		$this->videoService = $videoService;

	}

	public function index()
	{
		$data = $this->videoService->paginate();
		return $this->apiReturn($data);
	}

	public function info($id)
	{
		$item = $this->videoService->info($id);
		return $this->apiReturn($item);
	}



}
