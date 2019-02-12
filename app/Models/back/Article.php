<?php

namespace App\Models\back;

use App\Models\Disease;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
	protected $fillable = ['hits', 'title', 'disease_id', 'doctor_id', 'image', 'content'];
    //
    public function disease(){
        return $this->hasOne(Disease::class,'id','disease_id');
    }

    public function getClicksAttribute()
    {
    	return \Redis::hget(config('redisKeys.articleHits'), $this->attributes['id']) ?? $this->attributes['hits'];
    }

    public function scopeIsIndex($query)
    {
	    return $query->select(DB::raw('1 as `index`'), 'id', 'hits', 'title', 'disease_id', 'doctor_id', 'image', 'content');
    }

}
