<?php

namespace App\Service;

use App\Http\Resources\CollegeResource;
use App\Http\Resources\CollegeSectionContentResource;
use App\Http\Resources\CollegeSectionResource;
use App\Repository\CollegeRepository;
use Doctrine\DBAL\Driver\SQLAnywhere\SQLAnywhereException;
use Illuminate\Support\Facades\DB;

class CollegeService extends Service
{
	protected $repository;


	public function __construct(CollegeRepository $repository)
	{
		$this->repository = $repository;
	}


	public function backList($request)
	{
		$limit = $request->get('limit', 20);
		$items = $this->repository->backList($limit);
		$handleResult = CollegeResource::collection($items)->toArray(null);
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
		if($id) {
			$this->repository->updateById($id, $data);
		} else {
			$this->repository->create($data);
		}

		return ;
	}

	public function sections($id)
	{
		$sections = $this->repository->sectionList($id);
		$handleResult = CollegeSectionResource::collection($sections)->toArray(null);
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
		return ['data'=>$handleResult, 'meta'=> ['total'=>$items->total()]];
	}

	public function sectionContentIds($sectionId)
	{
		return $this->repository->contentIds($sectionId);
	}

	public function contentSave($request)
	{
		$id = $request->id;
		$data = $request->all();
		if($id){
			return $this->repository->contentUpdateById($id, $data);
		}
		else{
			DB::beginTransaction();
			try{
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
		DB::transaction(function () use($id) {
			$collegeId = $this->repository->collegeIdOfContent($id);
			$this->repository->contentDeleteById($id);
			$this->repository->updateCollegeContentCount($collegeId, -1);
		});
		return ;
	}

}