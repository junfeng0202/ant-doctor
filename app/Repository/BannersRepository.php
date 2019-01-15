<?php

namespace App\Repository;

use App\Models\Banner;
use App\Models\Banners;
use App\Models\Member;

class BannersRepository
{
	//根据banners位置获取banner
	public function getBanners($position=0)
	{
		return Banner::enable()->position($position)->get();
	}


}