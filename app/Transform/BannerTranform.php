<?php
namespace App\Transform;

use App\Models\Banners;

class BannerTranform extends TransformAbstract
{
	public function transform($banners)
	{
		return [
		    'url'=>$banners->link,
            'image' =>$banners->image
        ];
	}

}