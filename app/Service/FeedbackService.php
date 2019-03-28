<?php

namespace App\Service;

use App\Http\Resources\FeedbackResource;
use App\Repository\FeedbackRepository;

class FeedbackService extends Service
{
	protected $repository;


	public function __construct(FeedbackRepository $repository)
	{
		$this->repository = $repository;
	}


	/**
	 * 后台列表
	 * @param $request http-request
	 * @return array
	 */
	public function backList($request)
	{
		$feedbacks = $this->repository->getList($request->limit);
		$handlerFeedbacks = FeedbackResource::collection($feedbacks);
		return ['data'=>$handlerFeedbacks, 'meta'=>['total'=> $feedbacks->total()]];
	}

}