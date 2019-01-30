<?php

namespace App\Repository;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\CourseDoctor;

class CourseRepository
{
    //首页课程
	public function paginate($page=10, $sort='sort')
	{
		$course = Course::query();
		$course->latest($sort);
        return $course->isIndex()->enable()->withCount(['section'=>function($query){
        	$query->where('source_id','<>','');
        }])->with(['section:course_id,duration','disease:id,name','doctor:id,name'])->paginate($page);
	}
    //后台课程列表
    public function BackPaginate($page=10, $sort='sort',$kw=null)
    {
        $course = Course::query();
        $course->latest($sort);
        return $course->withCount(['section'=>function($query){
            $query->where('source_id','<>','');
        }])->with(['section:course_id,duration','disease:id,name','doctor:id,name'])->paginate($page);
    }
    //后台课程基本信息
    public function BackById($id){
	   return Course::with(['section:course_id,duration','disease:id,name','doctor:id,name'])->find($id);
    }
	public function getById($id)
	{
		return Course::with(['section'=>function($query){
			$query->with('children')->where('pid',0);
		}])->withCount(['section'=>function($query){
			$query->where('source_id','<>','');
		}])->find($id);
	}

	public function recommend($except_id,$disease,$limit=4)
	{
		return Course::where('disease_id',$disease)
			->where('id','<>',$except_id)
			->isIndex()
			->withCount(['section'=>function($query){
			$query->where('source_id','<>','');
			}])
			->with(['section:course_id,duration'])
			->latest()
			->limit($limit)
			->get();
	}

	public function BackUpdateOreCreate($data){
        return Course::updateOrCreate(['id'=>$data['id']],$data);
    }



    public function BackEdit(){

    }

}