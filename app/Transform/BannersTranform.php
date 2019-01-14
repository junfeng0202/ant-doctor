<?php
namespace App\Transform;

use App\Models\Banners;
use League\Fractal\TransformerAbstract;

class BannersTranform extends TransformerAbstract
{
	public function transform(Banners $banners)
	{
		return [
		    'url'=>$banners->link,
            'image' =>$banners->image,
            'positionStr' => '首页'
        ];
	}
}