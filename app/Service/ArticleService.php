<?php

namespace App\Service;

use App\Events\ArticleHit;
use App\Http\Resources\ArticleResource;
use App\Repository\ArticleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleService extends Service
{
	protected $articleRepository;


	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}


	public function index($request)
	{
		$items = $this->articleRepository->paginate($request->get('show_num',8), $request->get('sort','sort'));
		return ArticleResource::collection($items);
	}

	public function info($id)
	{
		$item = $this->articleRepository->getById($id);
		if(!$item){
			throw new ModelNotFoundException();
		}
		event(new ArticleHit($item));
		return new ArticleResource($item);
	}

}