<?php

namespace App\Service;

use App\Http\Resources\LiveResource;
use App\Repository\LiveRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LiveService extends Service
{
	protected $liveRepository;


	public function __construct(LiveRepository $liveRepository)
	{
		$this->liveRepository = $liveRepository;
	}

	public function index($request)
	{
		$items = $this->liveRepository->liveList($request->get('show_num',8));
		return LiveResource::collection($items);
	}

	public function info($id)
	{
		$item = $this->liveRepository->getById($id);
		if(!$item){
			throw new ModelNotFoundException();
		}

		return new LiveResource($item);
	}



    //后端接口-图文列表
    public function BackList($limit){
        $items = $this->liveRepository->BackPaginate($limit);
        return $items;
    }

    //后端接口-图文详情
    public function BackInfo($id){
        $item = $this->liveRepository->BackById($id);

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
        $corse = $this->liveRepository->BackUpdateOreCreate($data);
        //删除医生
//        if(isset($param['id']) && !empty($param['id'])){
//            DoctorVideo::where('video_id',$param['id'])->delete();
//        }
//        //添加医生
//        foreach($param['doctor_ids'] as $item){
//            DoctorVideo::insert(['video_id'=>$corse->id,'doctor_id'=>$item]);
//        }

    }
}