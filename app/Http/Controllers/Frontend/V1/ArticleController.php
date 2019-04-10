<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends ApiController
{
	protected $articleService;

	public function __construct(ArticleService $articleService)
	{
		$this->articleService = $articleService;

	}

	/**
	 * 文章列表
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(Request $request)
	{
		$data = $this->articleService->index($request);
		return $this->apiReturn($data);
	}

	/**
	 * 详情
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function info($id)
	{
		$data = $this->articleService->info($id);
		return $this->apiReturn($data);
	}



}
