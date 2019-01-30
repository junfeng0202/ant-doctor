<?php

namespace App\Repository;

use App\Models\back\VideoSection;

class VideoSectionRepository
{

	public function getById($id)
	{
		return VideoSection::find($id);
	}

    //后台获取课程章节
    public function BackById($id){
        return VideoSection::where('video_id','=',$id)->get();
    }

    //后台添加或者更新章节
    public function BackUpdateOreCreate($data){
        return VideoSection::updateOrCreate(['id'=>$data['id']],$data);
    }

}