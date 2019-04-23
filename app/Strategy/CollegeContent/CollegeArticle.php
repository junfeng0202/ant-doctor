<?php

namespace App\Strategy\CollegeContent;

use App\Http\Resources\ArticleResource;
use App\Repository\ArticleRepository;

class CollegeArticle implements ICollegeContent
{

	protected $repository;

	public function getContentList($sectionId, $sort, $size)
	{
		$this->repository = new ArticleRepository();
		$articles = $this->repository->collegeSectionArticle($sectionId, $sort, $size);
		return ArticleResource::collection($articles);
	}
}