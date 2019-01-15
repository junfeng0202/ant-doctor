<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\ArticleService;
use App\Service\IndexService;

class ArticleController extends ApiController
{
	protected $articleService;

	public function __construct(ArticleService $articleService)
	{
		$this->articleService = $articleService;

	}

	public function index()
	{
		$data = $this->articleService->paginate();
		return $this->apiReturn($data);
	}

	public function info($id)
	{
		$data = $this->articleService->info($id);
		return $this->apiReturn($data);
	}



}
