<?php

namespace App\Service;

use App\Http\Resources\LiveResource;
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
		$info = $this->liveRepository->info($id);
        $info =LiveResource::collection($info)->toArray(null);
        return $info;

    }

}