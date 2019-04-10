<?php

namespace App\Service;

use App\Events\CollegeHit;
use App\Http\Resources\CollegeResource;
use App\Http\Resources\CollegeSectionContentResource;
use App\Http\Resources\CollegeSectionResource;
use App\Models\CollegeSection;
use App\Repository\CollegeRepository;
use App\Strategy\CollegeArticle;
use App\Strategy\CollegeCourse;
use App\Strategy\CollegeVideo;
use App\Strategy\ICollegeContentType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CollegeService extends Service
{
	protected $repository;


	public function __construct(CollegeRepository $repository)
	{
		$this->repository = $repository;
	}


	/**
	 * 后端 讲堂列表
	 * @param $request
	 * @return array
	 */
	public function backList($request)
	{
		$limit = $request->get('limit', 20);
		$items = $this->repository->backList($limit);
		$handleResult = CollegeResource::collection($items);
		return ['data' => $handleResult, 'meta' => ['total' => $items->total()]];
	}

	/**
	 * 后端 讲堂详情
	 * @param $id
	 * @return CollegeResource
	 */
	public function backInfo($id)
	{
		$item = $this->repository->getById($id);
		return new CollegeResource($item);
	}

	/**
	 * 后端 更新讲堂信息
	 * @param $request
	 */
	public function updateOreCreate($request)
	{
		$id = $request->id;
		$data = $request->all();
		if ($id) {
			$this->repository->updateById($id, $data);
		} else {
			$this->repository->create($data);
		}

		$this->delCache($id);
		return;
	}

	/**
	 * 后端 讲堂频道列表
	 * @param $id
	 * @return array
	 */
	public function sections($id)
	{
		$sections = $this->repository->sectionList($id);
		$handleResult = CollegeSectionResource::collection($sections);
		return ['data' => $handleResult, 'meta' => ['total' => $sections->total()]];
	}

	/**
	 * 后端 讲堂频道详情
	 * @param $sectionId
	 * @return CollegeSectionResource
	 */
	public function sectionInfo($sectionId)
	{
		$item = $this->repository->sectionInfo($sectionId);
		return new CollegeSectionResource($item);
	}

	/**
	 * 后端 讲堂频道添加/修改
	 * @param $request
	 * @param $collegeId
	 * @return mixed
	 */
	public function sectionSave($request, $collegeId)
	{
		$data = $request->all();
		$data['college_id'] = $collegeId;
		$this->repository->sectionSave($data);

		$this->delCache($collegeId); // 清除讲堂缓存
	}

	/**
	 * 后端 讲堂频道下的内容列表
	 * @param $sectionId
	 * @return array
	 */
	public function sectionContentList($sectionId)
	{
		$items = $this->repository->contentList($sectionId);
		$handleResult = CollegeSectionContentResource::collection($items);
		return ['data' => $handleResult, 'meta' => ['total' => $items->total()]];
	}

	/**
	 * 后端 讲堂频道下的内容的id集合
	 * @param $sectionId
	 * @return mixed
	 */
	public function sectionContentIds($sectionId)
	{
		return $this->repository->contentIds($sectionId);
	}

	public function contentSave($request)
	{
		$id = $request->id;
		$data = $request->all();
		if ($id) {
			$res = $this->repository->contentUpdateById($id, $data);
		} else {
			DB::beginTransaction();
			try {
				$this->repository->updateCollegeContentCount($data['college_id']);
				$item = $this->repository->contentCreate($data);
				DB::commit();
				$res = ['id' => $item->id];
			} catch (\Exception $e) {
				DB::rollBack();
				throw $e;
			}
		}
		$this->delCache($data['college_id']); // 清除讲堂缓存
		return $res;
	}

	public function contentDelete($id)
	{
		DB::transaction(function () use ($id) {
			$collegeId = $this->repository->getCollegeIdOfContent($id);
			$this->repository->contentDeleteById($id);
			$this->repository->updateCollegeContentCount($collegeId, -1);
			$this->delCache($collegeId); // 清除讲堂缓存
		});
		return;
	}


	/**
	 * 前端获取讲堂列表
	 * @param $request
	 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function getList($request)
	{
		$colleges = $this->repository->getList($request->get('show_num', 10));
		return CollegeResource::collection($colleges);
	}

	/**
	 * 前端讲堂详情
	 * @param $id
	 * @return mixed
	 */
	public function getInfo($id)
	{
		$key = config('redisKeys.collegeInfo') . $id;

		if (!Redis::exists($key)) {
			$college = $this->repository->getInfo($id);
			if(!$college) throw new ModelNotFoundException();

			foreach ($college->section as &$section) {
				switch ($section->type) {
					case CollegeSection::COURSE:
						$size = 4;
						break;
					case CollegeSection::VIDEO:
						$size = 3;
						break;
					default:
						$size = 4;
				}
				$section->contents = $this->contentObject($section->type)->getContentList($section->id, 'sort', $size);

				$section->total = $section->content->count();

			}
			$info = new CollegeResource($college);

			Redis::set($key, json_encode($info)); //缓存
		}

		event(new CollegeHit($id)); // 增加点击量

		return json_decode(Redis::get($key), true);
//		return $info;
	}

	/**
	 * 前端 频道下的内容列表
	 * @param $sectionId
	 * @param $request
	 * @return mixed
	 */
	public function sectionContents($sectionId, $request)
	{
		$section = $this->repository->sectionInfo($sectionId);
		return $this->contentObject($section->type)->getContentList($sectionId, $request->get('sort', 'sort'), $request->get('show_num',20));
	}

	/**
	 * 根据类型返回相应的内容策略对象
	 * @param $type
	 * @return ICollegeContentType
	 */
	protected function contentObject($type) :ICollegeContentType
	{
		switch ($type) {
			case CollegeSection::COURSE:
				return new CollegeCourse();
			case CollegeSection::VIDEO:
				return new CollegeVideo();
			default:
				return new CollegeArticle();
		}
	}

	protected function delCache($id){
		$key = config('redisKeys.collegeInfo') . $id;
		Redis::del($key);
	}

}