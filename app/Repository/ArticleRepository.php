<?php

namespace App\Repository;

use App\Models\Article;

class ArticleRepository
{

	public function paginate($page=10)
	{
		return Article::latest('sort')->isIndex()->paginate($page);
	}

	public function getById($id)
	{
		return Article::find($id);
	}
}