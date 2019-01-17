<?php

namespace App\Service;

use App\Http\Resources\DiseaseResource;
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
		return DiseaseResource::collection($items)->toArray(null);
	}

}