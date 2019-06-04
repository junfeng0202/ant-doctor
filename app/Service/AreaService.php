<?php

namespace App\Service;

use App\Http\Resources\AreaResource;
use App\Repository\AreaRepository;

class AreaService extends Service
{
	protected $areaRepository;


	public function __construct(AreaRepository $areaRepository)
	{
		$this->areaRepository = $areaRepository;
	}


	/**
	 * 城市列表
	 * @return array
	 */
	public function province()
	{
		$items = $this->areaRepository->province();
		return AreaResource::collection($items)->toArray(null);
	}

}