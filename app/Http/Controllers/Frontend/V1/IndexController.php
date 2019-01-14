<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\MemberInfoRequest;
use App\Http\Requests\MemberRequest;
use App\Service\IndexService;
use App\Service\MemberService;
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
		return $this->indexService->index();
	}



}
