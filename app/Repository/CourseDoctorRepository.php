<?php

namespace App\Repository;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\CourseDoctor;

class CourseDoctorRepository
{
    public function BackDeletDoctorByCourseId($id){
        CourseDoctor::where('course_id',$id)->delete();
    }

    public function creat($data){
        CourseDoctor::insert($data);
    }
}