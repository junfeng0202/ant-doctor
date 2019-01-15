<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\ApiController;
use App\Http\Requests\PageRequest;
use App\Service\AreaService;
use App\Service\ArticleService;
use App\Service\DiseaseService;

class CommonController extends ApiController
{
	public function disease(DiseaseService $diseaseService)
	{
		$data = $diseaseService->disease();
		return $this->apiReturn($data);
	}

	public function province(AreaService $areaService)
	{
		return $this->apiReturn($areaService->province());
	}

}