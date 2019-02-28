<?php

namespace App\Repository;

use App\Models\Article;
use App\Models\back\Article as BackArticle;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleRepository
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
    public function BackPaginate($page=10, $sort='sort',$kw)
    {
        $video =BackArticle::query();
        $video->latest($sort);
        //搜索条件
        //标题
        if(isset($kw['kw_title'])){
            $video->where('title', 'like', '%'.$kw['kw_title'].'%');
        }
        //病种
        if(isset($kw['kw_disease'])){
            $video->where('disease_id','=',$kw['kw_disease']);
        }
        //讲者
        if(isset($kw['kw_doctor'])){
            $video->whereHas('doctor',
                function($query) use($kw){
                    $query->where('id', '=',$kw['kw_doctor']);
                });
        }
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

    public function BackCount(){
        return Article::count();
    }

    public function BackDelete($id){
        $info = Article::find($id);
        return $info->delete($id);
    }
}