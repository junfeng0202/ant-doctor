<?php

namespace App\Repository;

use App\Models\Article;

class ArticleRepository
{

	public function paginate($page=10,$sort='sort',$disease=0)
	{
		$article = Article::query();
		$article->latest($sort);
		$disease && $article->where('disease_id', $disease);
		return $article->isIndex()->paginate($page);
	}

	public function getById($id)
	{
		return Article::find($id);
	}
}