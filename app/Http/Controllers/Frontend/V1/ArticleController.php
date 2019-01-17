<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\ArticleService;
use App\Service\IndexService;
use Illuminate\Http\Request;

class ArticleController extends ApiController
{
	protected $articleService;

	public function __construct(ArticleService $articleService)
	{
		$this->articleService = $articleService;

	}

	public function index(Request $request)
	{
		$data = $this->articleService->index($request);
		return $this->apiReturn($data);
	}

	public function info($id)
	{
		$data = $this->articleService->info($id);
		return $this->apiReturn($data);
	}



}
