<?php

namespace App\Repository;


use App\Models\Doctor;

class DoctorRepository
{

	public function getAll()
	{
		$disease = Doctor::query();
		return $disease->get();
	}

    //==================================后台================================================
    //后台-banner列表
    public function BackPaginate($page=10, $sort='sort',$kw)
    {
        $query =Doctor::query();
        $query->latest($sort);
        return $query->paginate($page);
    }
    //后台-banner列表信息
    public function BackById($id){
        return Doctor::find($id);
    }

    //后台-banner列表更新
    public function BackUpdateOreCreate($data){
        return Doctor::updateOrCreate(['id'=>$data['id']],$data);
    }
    //==================================后台================================================

}