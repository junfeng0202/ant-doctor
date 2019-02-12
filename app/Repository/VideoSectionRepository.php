<?php

namespace App\Repository;
use App\Models\VideoSection;
use App\Models\back\VideoSection as BackVideoSection;

class VideoSectionRepository
{

	public function getById($id)
	{
		return VideoSection::find($id);
	}

    //后台获取课程章节
    public function BackById($id){
        return BackVideoSection::where('video_id','=',$id)->get();
    }

    //后台添加或者更新章节
    public function BackUpdateOreCreate($data){
        return BackVideoSection::updateOrCreate(['id'=>$data['id']],$data);
    }

}