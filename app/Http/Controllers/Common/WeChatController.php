<?php

namespace App\Http\Controllers\Common;


use App\Http\Controllers\ApiController;

class WeChatController extends ApiController
{
	protected $app;

	public function __construct()
	{
		$this->app = app('wechat.official_account');
	}

	public function serve()
	{
		$this->app->server->push(function($message){
			return "欢迎关注 overtrue！";
		});

		return $this->app->server->serve();
	}


	public function getCode()
	{
		return $this->app->oauth->scopes(['snsapi_userinfo'])->redirect();
	}

	public function user()
	{
		$user = $this->app->oauth->user();
		return $this->apiReturn([
			'openid'=> $user->getId(),
			'nickname'=> $user->getNickname(),
			'avatar'=> $user->getAvatar(),
			'gender'=> $user->getOriginal()['sex'],
		]);
	}
}