<?php

namespace App\Models\back;

use App\Models\Disease;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Live extends Model
{
    use SoftDeletes;

    //直播状态
	const BEGINING = 1;
	const WAITING = 2;
	const END = 3;

    protected $table = 'lives';

    protected $fillable = ['title', 'status', 'image', 'disease_id', 'start_at', 'end_at', 'link', 'brief','sort'];

	protected $dates = ['start_at', 'end_at','deleted_at'];

    protected $appends = ['live_time','doctor_str','doctor_ids'];       // 表里没有的字段


	public function doctor()
	{
		return $this->belongsToMany(Doctor::class);
	}

	public function disease()
	{
		return $this->belongsTo(Disease::class);
	}

	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.liveHits'), $this->attributes['id']) ?? $this->attributes['hits'];
	}

	public function scopeIsIndex($query)
	{
		return $query->select(DB::raw('1 as `index`'), 'id', 'title', 'status', 'image', 'disease_id', 'start_at', 'end_at', 'link', 'brief');
	}

	public function getStatus($key=null)
	{
		$arr = [
			['value'=>self::BEGINING, 'label'=>'直播中'],
			['value'=>self::WAITING, 'label'=>'未开始'],
			['value'=>self::END, 'label'=>'已结束'],
		];
		if(is_null($key)) return $arr;

		$index = collect($arr)->search(function ($item) use($key) {
			return $item['value'] == $key;
		});
		if($index !== false){
			return '';
		}else{
			return $arr[$index]['label'];
		}

	}
    public function getDoctorStrAttribute()
    {
        $name = [];
        foreach ($this->doctor as $v){
            $name[] = $v->name;
        }

        return implode('，',$name);
    }

    public function getDoctorIdsAttribute()
    {
        $ids = [];
        foreach ($this->doctor as $v){
            $ids[] = $v->id;
        }

        return $ids;
    }
    public function getliveTimeAttribute(){
        return date('Y/m/d H:i',strtotime($this->start_at)).' 至 '.date('Y/m/d H:i',strtotime($this->end_at));
    }
}
