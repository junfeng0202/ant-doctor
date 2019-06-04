<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    const INDEX = 0;

	protected $fillable = ['image', 'link', 'position', 'image', 'sort', 'enable'];
	protected $dates = ['deleted_at'];

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
