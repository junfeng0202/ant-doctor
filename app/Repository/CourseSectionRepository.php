<?php

namespace App\Repository;

use App\Models\CourseSection;

class CourseSectionRepository
{
    //首页课程

	public function getById($id)
	{
		return CourseSection::where('source_id','<>','')->find($id);
	}


}