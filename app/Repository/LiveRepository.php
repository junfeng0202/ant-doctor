<?php

namespace App\Repository;


use App\Models\Article;
use App\Models\Live;

class LiveRepository
{

	public function liveList()
	{
	    $live = Live::query();
	    $live = $live->with(['disease:id,name','doctor']);
        return $live;
	}

	//首页推荐直播
    public function livesOfIndex(){
        $live = Live::query();
        $live = $live->with(['disease:id,name','doctor']);
        $live = $live->where('created_at','>',date('Y-m-d H:i:s',strtotime('-2 Days')));
        return $live->get();
    }

    public function info($id){
        $live = Live::query();
        $live = $live->with(['disease:id,name','doctor']);
        $live = $live->where('id','=',$id);
        return $live->get();
    }
}