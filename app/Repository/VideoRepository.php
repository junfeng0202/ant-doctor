<?php

namespace App\Repository;

use App\Models\back\Video as BackVideo;
use App\Models\Video;
class VideoRepository
{


	public function paginate($page=10)
	{
		return Video::enable()->sort()->isIndex()->paginate($page);
	}

	public function getById($id)
	{
		return Video::enable()->with('section')->find($id);
	}


    //后台音频列表
    public function BackPaginate($page=10, $sort='sort')
    {
        $video =BackVideo::query();
        $video->latest($sort);
        return $video->with(['section:video_id,duration','disease:id,name','doctor:id,name'])->paginate($page);
    }
    //后台课程基本信息
    public function BackById($id){
        return BackVideo::with(['section:video_id,duration','disease:id,name','doctor:id,name'])->find($id);
    }
    public function BackUpdateOreCreate($data){
        return BackVideo::updateOrCreate(['id'=>$data['id']],$data);
    }


}