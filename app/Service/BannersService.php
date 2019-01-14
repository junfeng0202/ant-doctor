<?php

namespace App\Service;


use App\Models\Member;
use App\Proxy\ProxyService;
use App\Repository\MemberRepository;
use App\Repository\OauthRepository;
use Illuminate\Support\Facades\Auth;

class BannersService extends Service
{
	protected $bannersRepository;


	public function __construct(MemberRepository $memberRepository)
	{
		$this->memberRepository = $memberRepository;
	}



}