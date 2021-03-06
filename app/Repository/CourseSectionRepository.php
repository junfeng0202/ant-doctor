<?php

namespace App\Repository;

use App\Models\CourseSection;

class CourseSectionRepository
{
	//首页课程

	public function getById($id)
	{
		return CourseSection::where('source_id', '<>', '')->find($id);
	}

	//后台获取课程章节
	public function BackById($id, $limit)
	{
		return CourseSection::with(['children'])->where('course_id', $id)->where('pid', 0)->paginate($limit);
	}

	//后台添加或者更新章节
	public function BackUpdateOreCreate($data)
	{
		return CourseSection::updateOrCreate(['id' => $data['id']], $data);
	}

	public function sectionVideoCount($course_id)
	{
		return CourseSection::where('source_id', '!=', '')->where('course_id', $course_id)->count();
	}

}