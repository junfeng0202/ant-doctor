<?php

namespace App\Repository;

use App\Models\Video;

class VideoRepository
{


	public function paginate($size = 10, $disease_id = 0, $kw='')
	{
		$video = Video::query();
		$disease_id && $video->where('disease_id', $disease_id);
		$kw && $video->where('title', 'LIKE', '%' . $kw . '%');
		return $video->enable()->sort()->isIndex()->paginate($size);
	}

	public function getListByKeyword($kw, $size = 10)
	{
		$video = Video::query();
		$video->where('title', 'LIKE', '%' . $kw . '%');
		return $video->enable()->sort()->isIndex()->paginate($size);
	}

	public function getById($id)
	{
		return Video::enable()->with('section')->find($id);
	}

	public function collegeSectionVideo($sectionId, $sort = 'sort', $size = 20)
	{
		if ($sort === 'hot') {
			$order = 'c.hits';
		} elseif ($sort === 'newest') {
			$order = 'c.id';
		} else {
			$order = 'cs.sort';
		}
		return Video::from('videos as c')
			->rightJoin('college_section_contents as cs', 'cs.contentable_id', '=', 'c.id')
			->where('cs.college_section_id', $sectionId)
			->where('c.enable', 1)
			->select('c.*')
			->orderByDesc($order)->paginate($size);

	}


	//后台音频列表
	public function BackPaginate($page = 10, $sort = 'sort', $kw = null)
	{
		$video = Video::query();
		$video->latest($sort);
		//标题
		if (isset($kw['kw_title'])) {
			$video->where('title', 'like', '%' . $kw['kw_title'] . '%');
		}
		//病种
		if (isset($kw['kw_disease'])) {
			$video->where('disease_id', '=', $kw['kw_disease']);
		}
		//讲者
		if (isset($kw['kw_doctor'])) {
			$video->whereHas('doctor',
				function ($query) use ($kw) {
					$query->where('id', '=', $kw['kw_doctor']);
				});
		}
		return $video->with(['section:id,video_id,duration,hits', 'disease:id,name', 'doctor:id,name'])->isIndex()->paginate($page);
	}

	//后台课程基本信息
	public function BackById($id)
	{
		return Video::with(['section:video_id,duration', 'disease:id,name', 'doctor:id,name'])->find($id);
	}

	public function BackUpdateOreCreate($data)
	{
		return Video::updateOrCreate(['id' => $data['id']], $data);
	}

	public function BackCount()
	{
		return Video::enable()->count();
	}

}