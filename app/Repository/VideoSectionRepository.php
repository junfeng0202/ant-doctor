<?php

namespace App\Repository;
use App\Models\VideoSection;

class VideoSectionRepository
{

	public function getById($id)
	{
		return VideoSection::find($id);
	}


	public function getByVideoId($id, $size){
		return VideoSection::where('video_id', $id)->paginate($size);
	}


    //后台添加或者更新章节
    public function BackUpdateOreCreate($id, $data){
        return VideoSection::updateOrCreate(['id'=>$id],$data);
    }

}