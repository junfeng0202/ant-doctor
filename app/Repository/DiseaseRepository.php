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
		return $disease->sort()->get();
	}

    //==================================后台================================================
    //后台-病种列表
    public function BackPaginate($page=10, $sort='sort',$kw)
    {
        $query =Disease::query();
        $query->latest($sort);
        return $query->paginate($page);
    }
    //后台-病种列表信息
    public function BackById($id){
        return Disease::find($id);
    }

    //后台-病种列表更新
    public function BackUpdateOreCreate($data){
        return Disease::updateOrCreate(['id'=>$data['id']],$data);
    }

    public function BackDelete($id){
        $info = Disease::find($id);
        return $info->delete($id);
    }
    //==================================后台================================================
}