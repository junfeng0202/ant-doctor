<?php

namespace App\Http\Controllers\Common;


use App\Http\Controllers\ApiController;
use App\Service\ConfigService;
use EasyWeChat\Kernel\Messages\Article;
use Illuminate\Http\Request;

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
			return "欢迎关注 蚂蚁医生科普平台";
		});

		return $this->app->server->serve();
	}


    public function getUsers(){
	    return $this->app->user->list(null);
    }


	public function updateMenu(ConfigService $configService, Request $request)
	{
		$buttons = $request->get('button');
		$configService->updateWeChatMenu($buttons);
		return $this->apiReturn($this->app->menu->create($buttons));
	}

	public function synMenu(ConfigService $configService)
	{
		$buttons = $configService->getWeChatMenu();
		return $this->apiReturn($this->app->menu->create($buttons));
	}

	public function getMenu(ConfigService $configService)
	{
		$buttons = $configService->getWeChatMenu();
		return $this->apiReturn($buttons);
	}

	/**
	 * 蚂蚁照护 -- 用户授权，获取code
	 * @return mixed
	 */
	public function getCode()
	{
		return $this->app->oauth->scopes(['snsapi_userinfo'])->redirect();
	}

	/**
	 * 蚂蚁照护 -- 获取用户信息
	 * @return \Illuminate\Http\JsonResponse
	 */
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

	/**
	 * 医学V -- 用户授权，获取code
	 * @return mixed
	 */
	public function getVCode(Request $request)
	{
		$id = $request->id;
		return app('wechat.official_account.v')->oauth->scopes(['snsapi_base'])->redirect(env('WECHAT_V_CALLBACK').'?orderId='.$id);

	}

	/**
	 * 医学V -- 获取用户信息
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function userV()
	{
		$user = $this->app->oauth->user();
		return $this->apiReturn([
			'openid'=> $user->getId(),
		]);
	}

	public function materials(Request $request, $type='news')
	{
		$offset = $request->get('page', 0);
		$count = $request->get('size', 10);
		return $this->app->material->list($type, $offset, $count);
	}

	public function materialAdd()
	{
		$article = new Article([
			'title' => '测试',
			'thumb_media_id' => 'gmUmM3hbFZKH3ld5Skkk6Si-tV0PIMOywcznP9-xLuU',
			'content'=> '测试内容',
			'show_cover'=> 1,
			'content_source_url'=> '',
		]);
		return $this->app->material->uploadArticle($article);

		// $this->app->material->uploadArticle([$article]);
	}

	public function imageUpload()
	{
		return $this->app->material->uploadImage('static/img/404.a57b6f3.png');

		// $this->app->material->uploadArticle([$article]);
	}
}