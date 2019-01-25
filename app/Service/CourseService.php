<?php

namespace App\Service;

use App\Events\CourseHit;
use App\Http\Controllers\ApiController;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseSectionResource;
use App\Repository\CourseDoctorRepository;
use App\Repository\CourseRepository;
use App\Repository\CourseSectionRepository;
use App\Repository\MemberStudyRepository;
use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

class CourseService extends Service
{
	protected $courseRepository;


	public function __construct(CourseRepository $courseRepository)
	{
		$this->courseRepository = $courseRepository;
	}


	public function index($request)
	{
		$items = $this->courseRepository->paginate($request->get('show_num',8), $request->get('sort','sort'));
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

	public function BackInfo($id){
	    $item = $this->courseRepository->BackById($id);

        if(!$item){
            throw new ModelNotFoundException();
        }
        $info = new CourseResource($item);

        return $info;
    }

    public function BackUpdateOreCreate($param){

	    $data = array(
	        'title' => $param['title'],
            'disease_id' => $param['disease_id'],
            'brief' => $param['brief'],
            'image' => $param['image'],
            'sort' => $param['sort'],
            'enable' => isset($param['enable'])?$param['enable']:1,
            'hits' => isset($param['hits'])?$param['hits']:0
        );
	    if(isset($param['id']) && $param['id'] != ''){
	        $data['id'] = $param['id'];
        }else{
            $data['id'] = 0;
        }
        //更新基本信息
	    $corse = $this->courseRepository->BackUpdateOreCreate($data);
	    //删除医生
	    if(isset($param['id']) && !empty($param['id'])){
            (new CourseDoctorRepository())->BackDeletDoctorByCourseId($param['id']);
        }
        //添加医生
        foreach($param['doctor_ids'] as $item){
            (new CourseDoctorRepository())->creat(['course_id'=>$corse->id,'doctor_id'=>$item]);
        }

    }



	public function audio($audio_id)
	{
		$audio = (new CourseSectionRepository)->getById($audio_id);
		if(!$audio){
			throw new ModelNotFoundException();
		}

		return ['source'=>$audio->source_id];
	}


	public function study($request)
	{
		$data = $request->only('course_id', 'course_section_id', 'time', 'end');
		$data['member_id'] = JWTAuth::parseToken()->touser()->id;
		$collection = collect($data);
		$memberStudy = new MemberStudyRepository;
		$memberStudy->createStudyLog($data);
		$memberStudy->update($collection->only(['member_id','course_id'])->all(),$collection->except(['member_id','course_id'])->all());
	}

	protected function cacheSections($course_id, $section)
	{
		return Cache::rememberForever(config('course_section_key').$course_id,function ()use($section){
			return CourseSectionResource::collection($section);
		});
	}

	public function BackList($limit){
	    $items = $this->courseRepository->BackPaginate($limit);
//	    dd($items->toArray());
        return CourseResource::collection($items);
	}

}