<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
	//直播状态
	const BEGINING = 1;
	const WAITING = 2;
	const END = 3;

    protected $table = 'lives';

    protected $fillable = ['title', 'status', 'image', 'disease_id', 'start_at', 'end_at', 'link', 'playback', 'brief'];

	protected $dates = ['start_at', 'end_at'];


	public function doctor()
	{
		return $this->belongsToMany(Doctor::class);
	}

	public function disease()
	{
		return $this->belongsTo(Disease::class);
	}

    //前台api格式化数据
    public static function parseRow($item){
        $res = [];
        foreach ($item as $k=>$v){
            $res[] = [
                'live_id' =>$v->id,
                'liveTitle' => $v->title,
                'liveImg' =>$v->image,
                'liveStartDate' =>date('Y/m/d',strtotime($v->start_at)),
                'liveEndDate' =>date('Y/m/d',strtotime($v->end_at)),
            ];
        }
        return $res;
    }
}
