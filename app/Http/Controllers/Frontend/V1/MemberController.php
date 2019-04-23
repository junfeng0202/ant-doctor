<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\MemberInfoRequest;
use App\Service\MemberService;
use Illuminate\Http\Request;

class MemberController extends ApiController
{
	protected $memberService;

	public function __construct(MemberService $memberService)
	{
		$this->memberService = $memberService;

	}

	public function user()
	{
		$data = $this->memberService->getUser();
		return $this->apiReturn($data);
	}


	/**
	 * 编辑个人资料
	 * @param MemberInfoRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function editInfo(MemberInfoRequest $request)
	{
		$this->memberService->updateInfo($request);
		return $this->apiReturn();
	}


	/**
	 * 学习记录
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function studyHistory(Request $request)
	{

		return $this->apiReturn($this->memberService->studyHistory($request));
	}

	/**
	 * 提交反馈
	 * @param FeedbackRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function feedback(FeedbackRequest $request)
	{
		$this->memberService->feedback($request);
		return $this->apiReturn();
	}

	public function orders(Request $request)
	{
		return $this->apiReturn($this->memberService->orders($request));
	}
}
