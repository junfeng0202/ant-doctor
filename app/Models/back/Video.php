<?php

namespace App\Models\back;

use App\Models\Disease;
use App\Models\Doctor;
use App\Models\VideoSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Video extends Model
{
    protected $table='videos';
	protected $fillable = ['hits','title','disease_id','image','brief','sort','enable','disease'];
    protected $appends = ['doctor_str','doctor_ids','section_count'];       // 表里没有的字段

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
		return $this->hasMany(VideoSection::class)->orderBy('section_num');
	}

	public function scopeEnable($query)
	{
		return $query->where('enable',1);
	}

	public function scopeIsIndex($query)
	{
		return $query->select(DB::raw('1 as `index`'),'id','hits','title','disease_id','image','brief','sort','enable','created_at');
	}

	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.videoHits'), $this->attributes['id']) ?: $this->attributes['hits'];
	}

	public function scopeSort($query)
	{
		return $query->orderByDesc('sort');
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

    public function getSectionCountAttribute(){
        return VideoSection::where('video_id',$this->id)->count();
    }
}
