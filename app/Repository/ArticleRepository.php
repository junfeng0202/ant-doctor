<?php

namespace App\Repository;

use App\Models\Article;
use App\Models\back\Article as BackArticle;
use Illuminate\Support\Facades\DB;

class ArticleRepository
{

	/**
	 * 前端文章列表
	 * @param int $limit 查询结构数量
	 * @param array $interest 用户感兴趣的病种id
	 * @param string $sort 排序
	 * @param int $disease 病种筛选
	 * @param string $kw 关键词
	 * @return mixed
	 */
	public function paginate($limit = 10, $interest = [], $sort = 'sort', $disease = 0, $kw='')
	{
		$article = Article::with('disease:id,name')->isIndex()->latest('sort');
		$kw && $article->where('title', 'LIKE', '%'.$kw.'%');

		// 根据用户感兴趣的疾病推荐
		if ($sort != 'sort' && !$disease && count($interest)) {

			$articleClone = clone $article;

			$article->whereIn('disease_id', $interest);

			return Article::from(DB::raw("({$article->toSql()}) as a"))
				->mergeBindings($article->getQuery())->withTrashed()
				->union(
					Article::from(DB::raw("({$articleClone->toSql()}) as a"))
						->mergeBindings($article->getQuery())->withTrashed()
				)->paginate($limit);
		}
		//根据帅选条件查询
		$disease && $article->where('disease_id', $disease);
		return $article->paginate($limit);
	}

	public function getListByKeyword($kw, $limit = 10)
	{
		//根据帅选条件查询
		$article = Article::query();
		$article->where('title', 'LIKE', '%'.$kw.'%');
		return $article->isIndex()->latest('sort')->with('disease:id,name')->paginate($limit);
	}

	/**
	 * 文章详情
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function getById($id)
	{
		return Article::with('disease:id,name')->find($id);
	}

	public function collegeSectionArticle($sectionId, $sort='sort', $size=20)
	{
		if($sort === 'hot') {
			$order = 'articles.hits';
		} elseif($sort === 'newest') {
			$order = 'articles.id';
		} else {
			$order = 'cs.sort';
		}
		return Article::from('articles')
			->rightJoin('college_section_contents as cs', 'cs.contentable_id','=','articles.id')
			->where('cs.college_section_id', $sectionId)
			->select('articles.*', DB::raw('1 as `index`'))
			->orderByDesc($order)->paginate($size);
	}


	//后台-图文列表
	public function BackPaginate($page = 10, $sort = 'sort', $kw)
	{
		$video = BackArticle::query();
		$video->latest($sort);
		//搜索条件
		//标题
		if (isset($kw['kw_title'])) {
			$video->where('title', 'like', '%' . $kw['kw_title'] . '%');
		}
		//病种
		if (isset($kw['kw_disease'])) {
			$video->where('disease_id', '=', $kw['kw_disease']);
		}
		//讲者
		if (isset($kw['kw_doctor'])) {
			$video->whereHas('doctor',
				function ($query) use ($kw) {
					$query->where('id', '=', $kw['kw_doctor']);
				});
		}
		return $video->with(['disease:id,name'])->paginate($page);
	}

	//后台-图文信息
	public function BackById($id)
	{
		return BackArticle::with(['disease:id,name'])->find($id);
	}

	//后台-图文更新
	public function BackUpdateOreCreate($data)
	{
		return BackArticle::updateOrCreate(['id' => $data['id']], $data);
	}

	public function BackCount()
	{
		return Article::count();
	}

	public function BackDelete($id)
	{
		$info = Article::find($id);
		return $info->delete($id);
	}
}