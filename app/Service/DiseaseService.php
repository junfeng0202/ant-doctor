<?php

namespace App\Service;


use App\Proxy\ProxyService;
use App\Repository\DiseaseRepository;
use App\Repository\MemberRepository;
use App\Repository\OauthRepository;
use App\Transform\DiseaseTranform;
use Illuminate\Support\Facades\Auth;

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
		return $this->response->collection($items, new DiseaseTranform());
	}

}