<?php

namespace App\Repository;

use App\Models\Live;
use App\Models\back\Live as BackLive;

class LiveRepository
{

	public function liveList($page=8)
	{
	    return Live::where('status','<',Live::END)->isIndex()->paginate($page);
	}

	public function getById($id)
	{
		return Live::find($id);
	}


    //后台-图文列表
    public function BackPaginate($page=10, $sort='sort')
    {
        $video =BackLive::query();
//        $video->latest($sort);
        return $video->with(['disease:id,name','doctor:id,name'])->paginate($page);
    }
    //后台-图文信息
    public function BackById($id){
        return BackLive::with(['disease:id,name'])->find($id);
    }

    //后台-图文更新
    public function BackUpdateOreCreate($data){
        return BackLive::updateOrCreate(['id'=>$data['id']],$data);
    }

}