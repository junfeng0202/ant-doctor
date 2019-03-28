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
		$items = $this->articleRepository->paginate($request->get('show_num',8), $request->get('sort','sort'), $request->get('disease',0));
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

    //后端接口-图文列表
    public function BackList($limit,$kw){
        $items = $this->articleRepository->BackPaginate($limit,null,$kw);
        $handerResult = ArticleResource::collection($items);
        return ['data'=>$handerResult, 'meta'=>['total'=>$items->total()]];
    }

    //后端接口-图文详情
    public function BackInfo($id){
        $item = $this->articleRepository->BackById($id);

        if(!$item){
            throw new ModelNotFoundException();
        }

        return $item;
    }


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
        $corse = $this->articleRepository->BackUpdateOreCreate($data);
        //删除医生
//        if(isset($param['id']) && !empty($param['id'])){
//            DoctorVideo::where('video_id',$param['id'])->delete();
//        }
//        //添加医生
//        foreach($param['doctor_ids'] as $item){
//            DoctorVideo::insert(['video_id'=>$corse->id,'doctor_id'=>$item]);
//        }

    }

    //统计总数
    public function BackCount(){
        $res = $this->articleRepository->BackCount();
        return $res;
    }

    public function delete($id){
        return $this->articleRepository->BackDelete($id);
    }


}