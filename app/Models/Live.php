<?php

namespace App\Models;

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

    protected $fillable = ['title', 'status', 'image', 'disease_id', 'start_at', 'end_at', 'link', 'brief'];

	protected $dates = ['start_at', 'end_at','deleted_at'];


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

		$collection = collect($arr)->pluck('label', 'value')->all();
		return isset($collection[$key]) ? $collection[$key] : '';

	}

}
