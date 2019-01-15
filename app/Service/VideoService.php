<?php

namespace App\Service;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\VideoResource;
use App\Repository\ArticleRepository;
use App\Repository\VideoRepository;
use App\Transform\ArticleTranform;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VideoService extends Service
{
	protected $videoRepository;


	public function __construct(VideoRepository $videoRepository)
	{
		$this->videoRepository = $videoRepository;
	}


	public function paginate($page=10)
	{
		$items = $this->videoRepository->paginate($page);
		return VideoResource::collection($items);
	}

	public function info($id)
	{
		$item = $this->videoRepository->getById($id);
		if(!$item){
			throw new ModelNotFoundException();
		}
		return new VideoResource($item);
	}

}