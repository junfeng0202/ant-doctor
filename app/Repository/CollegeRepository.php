<?php

namespace App\Repository;

use App\Models\College;
use App\Models\CollegeSection;
use App\Models\CollegeSectionContent;

class CollegeRepository
{

	public function backList($limit)
	{
		$college = College::query();
		return $college->latest('id')->paginate($limit);
	}

	public function getById($id)
	{
		return College::find($id);
	}

	/**
	 * 更新讲堂信息
	 * @param $data
	 * @return mixed
	 */
	public function updateById($id, $data)
	{
		$college = College::find($id);
		$college->fill($data);
		return $college->save();
	}

	/**
	 * 新增讲堂
	 * @param $data
	 * @return mixed
	 */
	public function create($data)
	{
		return College::create($data);
	}

	public function updateCollegeContentCount($id, $num=1)
	{
		return College::whereId($id)->increment('content_count', $num);
	}

	public function sectionList($id, $limit = 20)
	{
		return CollegeSection::where('college_id', $id)->paginate($limit);
	}

	public function sectionInfo($sectionId)
	{
		return CollegeSection::find($sectionId);
	}


	public function sectionSave($data)
	{
		return CollegeSection::updateOrCreate(['id'=>$data['id']], $data);
	}

	public function contentList($sectionId, $limit = 20)
	{
		return CollegeSectionContent::where('college_section_id', $sectionId)->with('contentable')->latest('sort')->latest('id')->paginate($limit);
	}

	public function contentIds($sectionId)
	{
		return CollegeSectionContent::where('college_section_id', $sectionId)->pluck('contentable_id');
	}

	public function contentCreate($data)
	{
		return CollegeSectionContent::create($data);
	}

	public function contentUpdateById($id, $data)
	{
		return CollegeSectionContent::whereId($id)->update($data);
	}

	/**
	 * 通过id删除content记录
	 * @param $id
	 * @return int
	 */
	public function contentDeleteById($id)
	{
		return CollegeSectionContent::destroy($id);
	}

	/**
	 * 内容所属讲堂的id
	 * @param $id
	 * @return int
	 */
	public function collegeIdOfContent($id)
	{
		return CollegeSectionContent::whereId($id)->value('college_id');
	}
}