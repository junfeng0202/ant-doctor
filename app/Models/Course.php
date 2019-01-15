<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
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
		return $this->hasMany(CourseSection::class)->orderBy('sort');
	}

    //前台api格式化数据
    public static function parseRow($item){
        $res = [];
        foreach ($item as $k=>$v){
            $res[] = [
                'course_id' =>$v->id,
                'videoTitle' => $v->title,
                'videoImg' =>$v->image,
                'videoCount' =>$v->hits,
                'videoNumber' =>100,
                'videoDuration' =>19,
            ];
        }
        return $res;
    }
}
