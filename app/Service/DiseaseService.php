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
			'interest' => $datas->filter(function ($item) {
				return $item->type == Disease::INTERESTED;
			})->values(),
			'combine' => $datas->filter(function ($item) {
				return $item->type == Disease::COMBINE;
			})->values(),
			'complication' => $datas->filter(function ($item) {
				return $item->type == Disease::COMPLICATION;
			})->values(),
		];
	}

	//==================================后端接口===============================================
	//病种列表
	public function BackListTree()
	{
		$items = $this->diseaseRepository->getAll(false)->toArray();
		return $this->arrToTree($items);
	}

	//banner列表详情
	public function BackInfo($id)
	{
		$item = $this->diseaseRepository->BackById($id);
		return $item;
	}

	//更新banner列表
	public function BackUpdateOreCreate($param)
	{
		$id = $param['id'];
		unset($param['id']);
		$this->diseaseRepository->BackUpdateOreCreate($id, $param);
	}

	public function delete($id)
	{
		return $this->diseaseRepository->BackDelete($id);
	}

	//==================================后端接口===============================================


	protected function arrToTree(&$arr, $pid=0)
	{
		$result=[];
		foreach ($arr as $key=>$item) {
			if($item['pid'] == $pid){
				unset($arr[$key]);
				$item['children'] = $this->arrToTree($arr, $item['id']);
				$result[] = $item;
			}
		}
		return $result;
	}
}