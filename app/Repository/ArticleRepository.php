<?php

namespace App\Repository;

use App\Models\Article;
use App\Models\back\Article as BackArticle;
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


    //后台-图文列表
    public function BackPaginate($page=10, $sort='sort')
    {
        $video =BackArticle::query();
        $video->latest($sort);
        return $video->with(['disease:id,name'])->paginate($page);
    }
    //后台-图文信息
    public function BackById($id){
        return BackArticle::with(['disease:id,name'])->find($id);
    }

    //后台-图文更新
    public function BackUpdateOreCreate($data){
        return BackArticle::updateOrCreate(['id'=>$data['id']],$data);
    }
}