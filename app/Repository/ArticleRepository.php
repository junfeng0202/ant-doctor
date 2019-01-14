<?php

namespace App\Repository;


use App\Models\Article;

class ArticleRepository
{

	public function articleList()
	{
	    $Article = Article::query();
	    $Article = $Article->with('disease:id,name');
        return $Article;
	}
}