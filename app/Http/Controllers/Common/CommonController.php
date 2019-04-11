<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\ApiController;
use App\Proxy\OtherService;
use App\Service\AreaService;
use App\Service\DiseaseService;
use Illuminate\Http\Request;

class CommonController extends ApiController
{
	public function disease(DiseaseService $diseaseService)
	{
		$data = $diseaseService->disease();
		return $this->apiReturn($data);
	}

	//获取一级疾病
	public function topDisease(DiseaseService $service)
	{
		$data = $service->getTopDiseases();
		return $this->apiReturn($data);
	}

	public function province(AreaService $areaService)
	{
		return $this->apiReturn($areaService->province());
	}

	public function sms(Request $request)
	{
		if((new OtherService())->sendSms($request)){
			return $this->setIndex(102)->apiReturn();
		}else{
			return $this->setIndex(103)->apiReturn();
		}

	}

}