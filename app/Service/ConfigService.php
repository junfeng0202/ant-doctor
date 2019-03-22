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


	public function updateWeChatMenu($data)
	{
		$this->configRepository->updateOrCreate('wechatMenu', json_encode($data));
	}

	public function getWeChatMenu()
	{
		$menu = $this->configRepository->getValueByKey('wechatMenu');
		return json_decode($menu, true);
	}

}