<?php

namespace App\Service;

use App\Repository\LiveRepository;

class LiveService extends Service
{
	protected $liveRepository;


	public function __construct(LiveRepository $liveRepository)
	{
		$this->liveRepository = $liveRepository;
	}


	public function info($id)
	{
		return $this->liveRepository->info($id);
	}

}