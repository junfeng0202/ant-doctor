<?php

namespace App\Service;

use App\Http\Resources\BackDiseaseResource;
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

	/**
	 * 后端 获取病例筛选列表
	 * @return mixed
	 */
	public function getTopDiseases()
	{
		$items = $this->diseaseRepository->getTopDiseases();
		return BackDiseaseResource::collection($items);
	}

	/**
	 * 前端 获取所有病种
	 * @return array
	 */
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


	/**
	 * 病种列表
	 * @return array
	 */
	public function BackListTree()
	{
		$items = $this->diseaseRepository->getAll(false)->toArray();
		return $this->arrToTree($items);
	}


	/**
	 * banner详情
	 * @param $id
	 * @return mixed
	 */
	public function BackInfo($id)
	{
		$item = $this->diseaseRepository->BackById($id);
		return $item;
	}


	/**
	 * 更新banner
	 * @param $param
	 * @return mixed
	 */
	public function BackUpdateOreCreate($param)
	{
		$id = $param['id'];
		unset($param['id']);
		return $this->diseaseRepository->BackUpdateOreCreate($id, $param);
	}

	/**
	 * 删除
	 * @param $id
	 */
	public function delete($id)
	{
		$this->diseaseRepository->BackDelete($id);
	}

}