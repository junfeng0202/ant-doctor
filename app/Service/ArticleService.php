<?php

namespace App\Service;

use App\Events\ArticleHit;
use App\Http\Resources\ArticleResource;
use App\Repository\ArticleRepository;
use App\Repository\MemberRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleService extends Service
{
	protected $articleRepository;


	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}


	/**
	 * 前端文章列表
	 * @param $request
	 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function index($request)
	{
		$interest = (new MemberService(new MemberRepository()))->memberInterest();
		$items = $this->articleRepository->paginate($request->get('show_num',8), $interest, $request->get('sort','sort'), $request->get('disease',0), $request->get('keyword', ''));
		return ArticleResource::collection($items);
	}

	/**
	 * 详情
	 * @param $id
	 * @return ArticleResource
	 */
	public function info($id)
	{
		$item = $this->articleRepository->getById($id);
		if(!$item) throw new ModelNotFoundException();

		event(new ArticleHit($item));
		return new ArticleResource($item);
	}


	/**
	 * 图文列表
	 * @param $limit
	 * @param $kw
	 * @return array
	 */
	public function BackList($limit, $kw){
        $items = $this->articleRepository->BackPaginate($limit,null,$kw);
        $handerResult = ArticleResource::collection($items);
        return ['data'=>$handerResult, 'meta'=>['total'=>$items->total()]];
    }


	/**
	 * 图文详情
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function BackInfo($id){
        $item = $this->articleRepository->BackById($id);

        if(!$item){
            throw new ModelNotFoundException();
        }

        return $item;
    }


	/**
	 * 更新
	 * @param $param
	 */
	public function BackUpdateOreCreate($param){
        $data = array(
            'title' => $param['title'],
            'disease_id' => $param['disease_id'],
            'content' => $param['content'],
            'image' => $param['image'],
            'sort' => $param['sort'],
//            'enable' => isset($param['enable'])?$param['enable']:1,
            'hits' => isset($param['hits'])?$param['hits']:0
        );
        if(isset($param['id']) && $param['id'] != ''){
            $data['id'] = $param['id'];
        }else{
            $data['id'] = 0;
        }
        //更新基本信息
        $this->articleRepository->BackUpdateOrCreate($data);

    }

	/**
	 * 统计总数
	 * @return mixed
	 */
	public function BackCount(){
        $res = $this->articleRepository->BackCount();
        return $res;
    }

	/**
	 * 删除
	 * @param $id
	 * @return int
	 */
	public function delete($id){
        return $this->articleRepository->BackDelete($id);
    }


}