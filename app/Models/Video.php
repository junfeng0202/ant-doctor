<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

	public function doctor()
	{
		return $this->belongsToMany(Doctor::class);
	}

	public function disease()
	{
		return $this->belongsTo(Disease::class);
	}

	public function section()
	{
		return $this->hasMany(VideoSection::class)->where('parent_id',0);
	}

    //前台api格式化数据
    public static function parseRow($item){
        $res = [];
        foreach ($item as $k=>$v){
            $res[] = [
                'live_id' =>$v->id,
                'audioTitle' => $v->title,
                'audioImg' =>$v->image,
                'audioCount' =>$v->hits,
            ];
        }
        return $res;
    }
}
