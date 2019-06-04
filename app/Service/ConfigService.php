<?php

namespace App\Service;

use App\Repository\ConfigRepository;

class ConfigService extends Service
{
	protected $configRepository;


	public function __construct(ConfigRepository $configRepository)
	{
		$this->configRepository = $configRepository;
	}


	/**
	 * 更新微信公众号菜单
	 * @param $data
	 */
	public function updateWeChatMenu($data)
	{
		$this->configRepository->updateOrCreate('wechatMenu', json_encode($data));
	}

	/**
	 * 获取菜单列表
	 * @return mixed
	 */
	public function getWeChatMenu()
	{
		$menu = $this->configRepository->getValueByKey('wechatMenu');
		return json_decode($menu, true);
	}

}