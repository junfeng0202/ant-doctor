<?php

namespace App\Service;

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
		return $this->response->collection($items, new AreaTranform());
	}

}