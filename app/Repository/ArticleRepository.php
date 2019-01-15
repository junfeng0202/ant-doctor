<?php

namespace App\Repository;


use App\Models\Article;

class ArticleRepository
{

	public function paginate($page=10)
	{
		return Article::latest('sort')->paginate($page);
	}
}