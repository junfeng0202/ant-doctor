<?php

namespace App\Http\Controllers\Common;


class WechatController
{
	public function serve()
	{
		$app = app('wechat.official_account');
		$app->server->push(function($message){
			return "欢迎关注 overtrue！";
		});

		return $app->server->serve();
	}
}