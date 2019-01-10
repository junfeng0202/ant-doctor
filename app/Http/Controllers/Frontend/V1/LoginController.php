<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\MemberInfoRequest;
use App\Http\Requests\MemberRequest;
use App\Service\MemberService;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
	protected $memberService;

	public function __construct(MemberService $memberService)
	{
		//$this->middleware('guest')->except('logout');
		$this->memberService = $memberService;

	}

	public function login(MemberRequest $request)
	{
		return $this->memberService->login($request);
	}


	public function register(MemberRequest $request)
	{
		return $this->memberService->register($request);
	}

	public function info(MemberInfoRequest $request)
	{
		return $this->memberService->updateInfo($request);
	}
}
