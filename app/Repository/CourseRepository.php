<?php

namespace App\Repository;


use App\Models\Course;

class CourseRepository
{
    //首页课程
	public function paginate($page)
	{
        return Course::withCount(['section'=>function($query){
        	$query->where('source_id','<>','');
        }])->with(['section:course_id,duration'])->paginate($page);
	}

}