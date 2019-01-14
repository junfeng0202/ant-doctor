<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use App\Transform\ArticleTranform;
class ArticleService extends Service
{
	protected $articleRepository;


	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}


	public function articleList($request)
	{
		$items = $this->articleRepository->articleList();
		$items = $items->paginate($request->page_limit);
		return $this->response->paginator($items, new ArticleTranform());
	}

}