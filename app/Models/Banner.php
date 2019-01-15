<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    const INDEX = 0;

	/**
	 * 动态条件--广告位置
	 * @param $query
	 * @param int $position
	 * @return mixed
	 */
	public function scopePosition($query, $position=self::INDEX)
    {
		return $query->where('position', $position);
    }

    public function scopeEnable($query)
    {
    	return $query->where('enable', 1);
    }


    //格式化数据
    public static function parseRow($item){
        $res = [];
        foreach ($item as $k=>$v){
            $res[] = [
                'banner_id' =>$v->id,
                'url' => $v->link,
                'image' => $v->image,
                'positionStr' =>'首页'
            ];
        }
        return $res;
    }

}
