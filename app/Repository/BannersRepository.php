<?php

namespace App\Repository;

use App\Models\Banner;
use App\Models\back\Banner as BackBanner;


class BannersRepository
{
	//根据banners位置获取banner
	public function getBanners($position=0)
	{
		return Banner::enable()->latest('sort')->position($position)->get();
	}

	//==================================后台================================================
    //后台-banner列表
    public function BackPaginate($page=10, $sort='sort',$kw)
    {
        $query =BackBanner::query();
        $query->latest($sort);
        return $query->paginate($page);
    }
    //后台-banner列表信息
    public function BackById($id){
        return BackBanner::find($id);
    }

    //后台-banner列表更新
    public function BackUpdateOreCreate($data){
        return BackBanner::updateOrCreate(['id'=>$data['id']],$data);
    }
	//==================================后台================================================


}