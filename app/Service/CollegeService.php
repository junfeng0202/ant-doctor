<?php

namespace App\Service;

use App\Events\CollegeHit;
use App\Exceptions\ApiException;
use App\Http\Resources\CollegeResource;
use App\Http\Resources\CollegeSectionContentResource;
use App\Http\Resources\CollegeSectionResource;
use App\Models\CollegeSection;
use App\Repository\CollegeRepository;
use App\Repository\MemberCollegeRepository;
use App\Strategy\CollegeContent\CollegeArticle;
use App\Strategy\CollegeContent\CollegeCourse;
use App\Strategy\CollegeContent\CollegeVideo;
use App\Strategy\CollegeContent\ICollegeContent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function backList(Request $request)
	{
		$limit = $request->get('limit', 20);
		return $this->repository->backList($limit);
	}

	/**
	 * 后端 讲堂详情
	 * @param $id
	 * @return CollegeResource
	 */
	public function backInfo($id)
	{
		return $this->repository->getById($id);

	}

	/**
	 * 后端 更新讲堂信息
	 * @param $request
	 */
	public function updateOreCreate(Request $request)
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
		return $this->repository->sectionList($id);
	}

	/**
	 * 后端 讲堂频道详情
	 * @param $sectionId
	 * @return CollegeSectionResource
	 */
	public function sectionInfo($sectionId)
	{
		return $this->repository->sectionInfo($sectionId);
	}

	/**
	 * 后端 讲堂频道添加/修改
	 * @param $request
	 * @param $collegeId
	 * @return mixed
	 */
	public function sectionSave(Request $request, $collegeId)
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

	public function contentSave(Request $request)
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
	public function getList(Request $request)
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
			if (!$college) throw new ModelNotFoundException();

			$college->load(['section' => function ($query) {
				$query->enable();
			}]);

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
				$section->maxShowNum = $size;

			}
			$info = new CollegeResource($college);

			Redis::set($key, json_encode($info)); //缓存
		}

		event(new CollegeHit($id)); // 增加点击量

		$college = json_decode(Redis::get($key), true);
		$college['buyStatus'] = $this->memberCollegeStatus($id);
		return $college;
	}

	public function cardInfo($id)
	{
		$college = $this->repository->getById($id);
		if(!$college->sold_on || !$this->memberCollegeStatus($id)) {
			throw new ApiException('您已拥有该学习卡，或学习卡已关闭');
		}
		return new CollegeResource($college);
	}

	/**
	 * 前端 频道下的内容列表
	 * @param $sectionId
	 * @param $request
	 * @return mixed
	 */
	public function sectionContents($sectionId, Request $request)
	{
		$section = $this->repository->sectionInfo($sectionId);
		return $this->contentObject($section->type)->getContentList($sectionId, $request->get('sort', 'sort'), $request->get('show_num', 20));
	}

	/**
	 * 根据类型返回相应的内容策略对象
	 * @param $type
	 * @return CollegeArticle
	 */
	protected function contentObject($type): ICollegeContent
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

	/**
	 * 清除讲堂详情缓存
	 * @param $id
	 */
	protected function delCache($id)
	{
		$key = config('redisKeys.collegeInfo') . $id;
		Redis::del($key);
	}

	/**
	 * 用户购买状态
	 * @return bool
	 */
	protected function memberCollegeStatus($id)
	{
		$user = Auth::user();
		return $user ? (new MemberCollegeRepository())->buyStatus($user->id, $id) : false;
	}
}