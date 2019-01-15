<?php

namespace App\Service;

use App\Http\Resources\ArticleResource;
use App\Repository\ArticleRepository;
use App\Transform\ArticleTranform;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleService extends Service
{
	protected $articleRepository;


	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}


	public function paginate($page=10)
	{
		$items = $this->articleRepository->paginate($page);
		return ArticleResource::collection($items);
	}

	public function info($id)
	{
		$item = $this->articleRepository->getById($id);
		if(!$item){
			throw new ModelNotFoundException();
		}
		return new ArticleResource($item);
	}

}