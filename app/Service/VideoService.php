<?php

namespace App\Service;

use App\Events\VideoHit;
use App\Events\VideoSectionHit;
use App\Http\Resources\VideoResource;
use App\Repository\VideoRepository;
use App\Repository\VideoSectionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VideoService extends Service
{
	protected $videoRepository;


	public function __construct(VideoRepository $videoRepository)
	{
		$this->videoRepository = $videoRepository;
	}


	public function paginate($request)
	{
		$items = $this->videoRepository->paginate($request->get('show_num',8));
		return VideoResource::collection($items);
	}

	public function info($id)
	{
		$item = $this->videoRepository->getById($id);
		if(!$item){
			throw new ModelNotFoundException();
		}
		event(new VideoHit($item));
		return new VideoResource($item);
	}

	public function section($id)
	{
		$section = (new VideoSectionRepository())->getById($id);
		if(!$section){
			throw new ModelNotFoundException();
		}

		event(new VideoSectionHit($section));
		return ['video_url'=>$section->url];
	}

}