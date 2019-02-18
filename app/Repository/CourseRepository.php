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
        return $course->isIndex()->enable()->with(['section:course_id,duration','disease:id,name','doctor:id,name'])->paginate($page);
	}
    //后台课程列表
    public function BackPaginate($page=10, $sort='sort',$kw=null)
    {
        $course = Course::query();
        $course->latest($sort);
        //搜索条件
        //标题
        if(isset($kw['kw_title'])){
            $course->where('title', 'like', '%'.$kw['kw_title'].'%');
        }
        //病种
        if(isset($kw['kw_disease'])){
            $course->where('disease_id','=',$kw['kw_disease']);
        }
        //讲者
        if(isset($kw['kw_doctor'])){
            $course->whereHas('doctor',
                function($query) use($kw){
                    $query->where('id', '=',$kw['kw_doctor']);
            });
        }
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
		}])->find($id);
	}

	public function recommend($except_id,$disease,$limit=4)
	{
		return Course::where('disease_id',$disease)
			->where('id','<>',$except_id)
			->isIndex()
			->enable()
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