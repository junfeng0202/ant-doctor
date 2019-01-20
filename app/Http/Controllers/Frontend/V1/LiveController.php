<?php
namespace App\Http\Controllers\Frontend\V1;

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

	public function index(Request $request)
	{
		$data = $this->liveService->index($request);
		return $this->apiReturn($data);
	}

	public function info($id)
	{
		return $this->apiReturn($this->liveService->info($id));
	}



}
