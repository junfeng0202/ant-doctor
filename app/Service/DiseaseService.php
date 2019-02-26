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
			}),
			'combine'=>$datas->filter(function ($item) {
				return $item->type == Disease::COMBINE;
			}),
			'complication'=>$datas->filter(function ($item) {
				return $item->type == Disease::COMPLICATION;
			}),
		];
	}

}