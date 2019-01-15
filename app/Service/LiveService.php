<?php

namespace App\Service;

use App\Http\Resources\LiveResource;
use App\Repository\LiveRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LiveService extends Service
{
	protected $liveRepository;


	public function __construct(LiveRepository $liveRepository)
	{
		$this->liveRepository = $liveRepository;
	}

	public function index()
	{
		$items = $this->liveRepository->liveList();
		return LiveResource::collection($items);
	}

	public function info($id)
	{
		$item = $this->liveRepository->getById($id);
		if(!$item){
			throw new ModelNotFoundException();
		}

		return new LiveResource($item);
	}
}