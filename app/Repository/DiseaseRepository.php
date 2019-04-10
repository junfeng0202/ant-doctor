<?php

namespace App\Repository;


use App\Models\Disease;

class DiseaseRepository
{

	public function getAll($onlyEnable=true,$type=null)
	{
		$disease = Disease::query();
		$onlyEnable && $disease->where('enable',1);
        is_null($type) || $disease->where('type', $type);
		return $disease->sort()->select('id','name','pid','type')->get();
	}

    //==================================后台================================================

    //后台-病种列表信息
    public function BackById($id){
        return Disease::find($id);
    }

    //后台-病种列表更新
    public function BackUpdateOreCreate($id, $data){
        return Disease::updateOrCreate(['id'=>$id],$data);
    }

    public function BackDelete($id){
    	Disease::where('pid', $id)->delete();
        Disease::destroy($id);
    }
    //==================================后台================================================
}