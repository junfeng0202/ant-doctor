<?php

namespace App\Http\Controllers\Common;


class WeChatController
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
		return $this->app->oauth->user();
	}
}