<?php

namespace App\Service;

use App\Events\CourseHit;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseSectionResource;
use App\Repository\CourseRepository;
use App\Repository\CourseSectionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class CourseService extends Service
{
	protected $courseRepository;


	public function __construct(CourseRepository $courseRepository)
	{
		$this->courseRepository = $courseRepository;
	}


	public function index($request)
	{
		$items = $this->courseRepository->paginate(8, $request->get('sort','sort'));
		return CourseResource::collection($items);
	}

	public function info($id)
	{
		$item = $this->courseRepository->getById($id);
		if(!$item){
			throw new ModelNotFoundException();
		}

		event(new CourseHit($item));

		$item->chapters = $this->cacheSections($id, $item->section);//章节
		$info = new CourseResource($item);

		$recommends = $this->courseRepository->recommend($except_id = $item->id ,$item->disease_id);
		$recommends = CourseResource::collection($recommends);
		return ['info'=>$info, 'recommend'=>$recommends];
	}

	public function audio($audio_id)
	{
		$audio = (new CourseSectionRepository)->getById($audio_id);
		if(!$audio){
			throw new ModelNotFoundException();
		}

		return ['source'=>$audio->source_id];
	}

	protected function cacheSections($course_id, $section)
	{
		return Cache::rememberForever(config('course_section_key').$course_id,function ()use($section){
			return CourseSectionResource::collection($section);
		});
	}

	public function BackList($limit){
	    $items = $this->courseRepository->paginate($limit);
//	    dd($items->toArray());
        return CourseResource::collection($items);
	}

}