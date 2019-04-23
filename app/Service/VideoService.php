<?php

namespace App\Service;

use App\Events\VideoHit;
use App\Events\VideoSectionHit;
use App\Exceptions\ApiException;
use App\Http\Resources\VideoResource;
use App\Http\Resources\VideoSectionResource;
use App\Models\back\DoctorVideo;
use App\Repository\CourseSectionRepository;
use App\Repository\MemberVideoRepository;
use App\Repository\VideoRepository;
use App\Repository\VideoSectionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoService extends Service
{
	protected $videoRepository;


	public function __construct(VideoRepository $videoRepository)
	{
		$this->videoRepository = $videoRepository;
	}


	public function paginate(Request $request)
	{
		$items = $this->videoRepository->paginate($request->get('show_num', 8), $request->get('disease', 0), $request->get('keyword', ''));
		return VideoResource::collection($items);
	}

	public function info($id)
	{
		$item = $this->videoRepository->getById($id);
		if (!$item) throw new ModelNotFoundException();
		event(new VideoHit($item));

		$video = (new VideoResource($item))->toArray(null);
		$video['buyStatus'] = $this->memberVideoStatus($id);
		return $video;
	}

	/**
	 * 获取音频链接
	 * @param $id
	 * @return array
	 */
	public function section($id)
	{
		$section = (new VideoSectionRepository())->getById($id);
		if (!$section) throw new ModelNotFoundException();
		event(new VideoSectionHit($section));

		if(!$section->is_free || !$this->memberVideoStatus($id)) throw new ApiException('请先购买');

		return ['title' => $section->title, 'video_url' => $section->url];
	}


	//后段服务
	public function BackList($limit, $kw)
	{
		return $this->videoRepository->BackPaginate($limit, 'sort', $kw);
	}

	public function BackInfo($id)
	{
		$item = $this->videoRepository->BackById($id);

		if (!$item) throw new ModelNotFoundException();

		$item->load(['disease:id,name']);

		$item->doctor_ids = $item->doctor->pluck('id');
		return $item;
	}

	public function BackUpdateOreCreate($param)
	{
		//更新基本信息
		$corse = $this->videoRepository->BackUpdateOreCreate($param);
		$corse->doctor()->sync($param['doctor_ids']);

	}

	//后台添加章节
	public function BackAddSection($audio, $request)
	{
		$id = $request->id;
		//编辑节
		$data = array(
			'title' => $request->title,
			'url' => $request->url,
			'duration' => $request->duration,
			'section_num' => $request->section_num,
			'video_id' => $audio,
			'is_free' => $request->is_free
		);
		(new VideoSectionRepository())->BackUpdateOreCreate($id, $data);
	}

	public function BackSections($id, $request)
	{
		return (new VideoSectionRepository())->getByVideoId($id, $request->get('limit', 20));
	}

	//统计总数
	public function BackCount()
	{
		$res = $this->videoRepository->BackCount();
		return $res;
	}

	/**
	 * 用户购买状态
	 * @return bool
	 */
	protected function memberVideoStatus($id)
	{
		$user = Auth::user();
		return $user ? (new MemberVideoRepository())->buyStatus($user->id, $id) : false;
	}
}