<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\LiveService;

class LiveController extends ApiController
{
	protected $liveService;

	public function __construct(LiveService $liveService)
	{
		$this->liveService = $liveService;

	}

	public function index()
	{
		$data = $this->liveService->index();
		return $this->apiReturn($data);
	}

	public function info($id)
	{
		return $this->apiReturn($this->liveService->info($id));
	}



}
