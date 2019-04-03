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
use Doctrine\DBAL\Driver\SQLAnywhere\SQLAnywhereException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CollegeService extends Service
{
	protected $repository;
	protected $contentStrategy;


	public function __construct(CollegeRepository $repository)
	{
		$this->repository = $repository;
	}


	public function backList($request)
	{
		$limit = $request->get('limit', 20);
		$items = $this->repository->backList($limit);
		$handleResult = CollegeResource::collection($items);
		return ['data' => $handleResult, 'meta' => ['total' => $items->total()]];
	}

	public function backInfo($id)
	{
		$item = $this->repository->getById($id);
		return new CollegeResource($item);
	}

	public function updateOreCreate($request)
	{
		$id = $request->id;
		$data = $request->all();
		if ($id) {
			$this->repository->updateById($id, $data);
		} else {
			$this->repository->create($data);
		}

		return;
	}

	public function sections($id)
	{
		$sections = $this->repository->sectionList($id);
		$handleResult = CollegeSectionResource::collection($sections);
		return ['data' => $handleResult, 'meta' => ['total' => $sections->total()]];
	}

	public function sectionInfo($sectionId)
	{
		$item = $this->repository->sectionInfo($sectionId);
		return new CollegeSectionResource($item);
	}

	public function sectionSave($request, $collegeId)
	{
		$data = $request->all();
		$data['college_id'] = $collegeId;
		return $this->repository->sectionSave($data);
	}

	public function sectionContentList($sectionId)
	{
		$items = $this->repository->contentList($sectionId);
		$handleResult = CollegeSectionContentResource::collection($items);
		return ['data' => $handleResult, 'meta' => ['total' => $items->total()]];
	}

	public function sectionContentIds($sectionId)
	{
		return $this->repository->contentIds($sectionId);
	}

	public function contentSave($request)
	{
		$id = $request->id;
		$data = $request->all();
		if ($id) {
			return $this->repository->contentUpdateById($id, $data);
		} else {
			DB::beginTransaction();
			try {
				$this->repository->updateCollegeContentCount($data['college_id']);
				$item = $this->repository->contentCreate($data);
				DB::commit();
				return ['id' => $item->id];
			} catch (\Exception $e) {
				DB::rollBack();
				throw $e;
			}
		}
	}

	public function contentDelete($id)
	{
		DB::transaction(function () use ($id) {
			$collegeId = $this->repository->collegeIdOfContent($id);
			$this->repository->contentDeleteById($id);
			$this->repository->updateCollegeContentCount($collegeId, -1);
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
		//$key = config('redisKeys.collegeInfo') . $id;

		//if (!Redis::exists($key)) {
			$college = $this->repository->getInfo($id);

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
				$section->total = $section->content->count();
				$section->load(['content' => function ($query) use ($size) {
					$query->limit($size)->with('contentable');
				}]);
			}
			$info = new CollegeResource($college);

			//Redis::setex($key, 7200, json_encode($info)); //缓存2小时
		//}

		event(new CollegeHit($id)); // 增加点击量

//		return json_decode(Redis::get($key), true);
		return $info;
	}

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

}