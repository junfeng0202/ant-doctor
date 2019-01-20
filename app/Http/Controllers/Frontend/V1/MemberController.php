<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
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


	public function editInfo(MemberInfoRequest $request)
	{
		$this->memberService->updateInfo($request);
		return $this->apiReturn();
	}


	public function studyHistory(Request $request)
	{

		return $this->apiReturn($this->memberService->studyHistory($request));
	}

}
