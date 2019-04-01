<?php

namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\IndexService;
use Illuminate\Http\Request;

class IndexController extends ApiController
{
	protected $indexService;

	public function __construct(IndexService $indexService)
	{
		$this->indexService = $indexService;

	}

	public function index()
	{
		$data = $this->indexService->index();
		return $this->apiReturn($data);
	}

	public function search(Request $request)
	{
		$data = $this->indexService->search($request);
		return $this->apiReturn($data);
	}

}
