<?php

namespace App\Service;

use App\Events\CourseHit;
use App\Http\Controllers\ApiController;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseSectionResource;
use App\Models\CourseSection;
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
		$items = $this->courseRepository->paginate($request->get('show_num',8), $request->get('sort','sort'),  $request->get('disease', 0), $request->get('keyword',''));
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
            'havesection' => (int)$param['havesection'],
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

    //后天添加章节
    public function BackAddSection($course_id,$param){
	    if($param['pid'] == 0){
	        //编辑章
            $data = array(
                'id' => $param['id'],
                'pid' => 0,
                'title' => $param['title'],
                'course_id' => $course_id,

            );
        }else{
	        //编辑节
            $data = array(
                'id' => $param['id'],
                'pid' => $param['pid'],
                'title' => $param['title'],
                'source_id' => $param['source_id'],
                'duration' => $param['duration_int'],
                'course_id' => $course_id
            );
        }
        $res = (new CourseSectionRepository())->BackUpdateOreCreate($data);
        //更新章节数
        $data = array(
            'id' =>$course_id,
            'audio_count' =>CourseSection::where('pid','!=',0)->where('course_id',$course_id)->count()
        );
        $this->courseRepository->BackUpdateOreCreate($data);

    }
    public function BackSections($id){
        $items = (new CourseSectionRepository())->BackById($id);
        return $items;
        return CourseSectionResource::collection($items);
    }



	public function audio($audio_id)
	{
		$audio = (new CourseSectionRepository)->getById($audio_id);
		if(!$audio){
			throw new ModelNotFoundException();
		}

		return ['title'=>$audio->title,'fileID'=>$audio->source_id,'appID'=>config('config.appID')];
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
		/*return Cache::rememberForever(config('course_section_key').$course_id,function ()use($section){
			return CourseSectionResource::collection($section);
		});*/

		//todo 开发阶段，暂时不缓存
		return CourseSectionResource::collection($section);
	}

	public function BackList($limit,$kw){
	    $items = $this->courseRepository->BackPaginate($limit,null,$kw);
		return CourseResource::collection($items);

	}

    //统计用户总数
    public function BackCount(){
        $res = $this->courseRepository->BackCount();
        return $res;
    }



}