<?php

namespace App\Repository;


use App\Models\Course;

class CourseRepository
{
    //首页课程
	public function paginate($page=10)
	{
        return Course::withCount(['section'=>function($query){
        	$query->where('source_id','<>','');
        }])->with(['section:course_id,duration','disease:id,name','doctor:id,name'])->paginate($page);
	}

	public function getById($id)
	{
		return Course::with('section.children')->find($id);
	}

}