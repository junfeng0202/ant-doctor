<?php

namespace App\Repository;

use App\Models\Live;
use App\Models\back\Live as BackLive;

class LiveRepository
{

	public function liveList($page=8,$sort='sort')
	{
	    return Live::where('status','<',Live::END)->isIndex()->latest($sort)->paginate($page);
	}

	public function getById($id)
	{
		return Live::find($id);
	}


    //后台-图文列表
    public function BackPaginate($page=10, $sort='sort',$kw)
    {
        $video =BackLive::query();
        //搜索条件
        //标题
        if(isset($kw['kw_title'])){
            $video->where('title', 'like', '%'.$kw['kw_title'].'%');
        }
        //病种
        if(isset($kw['kw_disease'])){
            $video->where('disease_id','=',$kw['kw_disease']);
        }
        //讲者
        if(isset($kw['kw_doctor'])){
            $video->whereHas('doctor',
                function($query) use($kw){
                    $query->where('id', '=',$kw['kw_doctor']);
                });
        }
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

    public function BackDelete($id){
        $info = Live::find($id);
        return $info->delete($id);
    }

}