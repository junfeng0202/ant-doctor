<?php

namespace App\Service;

use App\Events\VideoHit;
use App\Events\VideoSectionHit;
use App\Http\Resources\VideoResource;
use App\Models\back\DoctorVideo;
use App\Repository\CourseSectionRepository;
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
		return ['title'=>$section->title,'video_url'=>$section->url];
	}


	//后段服务
    public function BackList($limit){
        $items = $this->videoRepository->BackPaginate($limit);
//        $res =  VideoResource::collection($items);
        return $items;
    }

    public function BackInfo($id){
        $item = $this->videoRepository->BackById($id);

        if(!$item){
            throw new ModelNotFoundException();
        }
//        $info = new CourseResource($item);

        return $item;
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
        $corse = $this->videoRepository->BackUpdateOreCreate($data);
        //删除医生
        if(isset($param['id']) && !empty($param['id'])){
            DoctorVideo::where('video_id',$param['id'])->delete();
            }
        //添加医生
        foreach($param['doctor_ids'] as $item){
            DoctorVideo::insert(['video_id'=>$corse->id,'doctor_id'=>$item]);
        }

    }

    //后台添加章节
    public function BackAddSection($audio,$param){

            //编辑节
            $data = array(
                'id' => $param['id'],
                'title' => $param['title'],
                'url' => $param['url'],
                'duration' => $param['duration'],
                'video_id' => $audio
            );

        $res = (new VideoSectionRepository())->BackUpdateOreCreate($data);


    }
    public function BackSections($id){
        $items = (new VideoSectionRepository())->BackById($id);
        return $items;
    }

}