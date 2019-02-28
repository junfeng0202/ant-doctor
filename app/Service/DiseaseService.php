<?php

namespace App\Service;

use App\Http\Resources\DiseaseResource;
use App\Models\Disease;
use App\Repository\DiseaseRepository;

class DiseaseService extends Service
{
	protected $diseaseRepository;


	public function __construct(DiseaseRepository $diseaseRepository)
	{
		$this->diseaseRepository = $diseaseRepository;
	}


	public function disease()
	{
		$items = $this->diseaseRepository->getAll();
		$datas = DiseaseResource::collection($items);
		return [
			'interest'=>$datas->filter(function ($item) {
				return $item->type == Disease::INTERESTED;
			})->values(),
			'combine'=>$datas->filter(function ($item) {
				return $item->type == Disease::COMBINE;
			})->values(),
			'complication'=>$datas->filter(function ($item) {
				return $item->type == Disease::COMPLICATION;
			})->values(),
		];
	}

    //==================================后端接口===============================================
    //病种列表
    public function BackList($limit,$kw){
        $items = $this->diseaseRepository->BackPaginate($limit,null,$kw);
        return $items;
    }

    //banner列表详情
    public function BackInfo($id){
        $item = $this->diseaseRepository->BackById($id);
        return $item;
    }

    //更新banner列表
    public function BackUpdateOreCreate($param){
        $data = array(
            'name' => $param['name'],
            'pid' => isset($param['pid'])?$param['pid']:0,
            'sort' => $param['sort'],
            'enable' => isset($param['enable'])?$param['enable']:1,
            'type' => $param['type'],
        );
        if(isset($param['id']) && $param['id'] != ''){
            $data['id'] = $param['id'];
        }else{
            $data['id'] = 0;
        }
        //更新基本信息
        $this->diseaseRepository->BackUpdateOreCreate($data);

    }

    public function delete($id){
        return $this->diseaseRepository->BackDelete($id);
    }

    //==================================后端接口===============================================


}