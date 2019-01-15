<?php

namespace App\Service;

use App\Http\Resources\AreaResource;
use App\Repository\AreaRepository;
use App\Transform\AreaTranform;

class AreaService extends Service
{
	protected $areaRepository;


	public function __construct(AreaRepository $areaRepository)
	{
		$this->areaRepository = $areaRepository;
	}


	public function province()
	{
		$items = $this->areaRepository->province();
		return AreaResource::collection($items)->toArray(null);
	}

}