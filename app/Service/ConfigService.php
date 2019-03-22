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
		$this->configRepository->updateOrCreate('wechatMenu', $data);
	}

	public function getWeChatMenu()
	{
		$this->configRepository->getValueByKey('wechatMenu');
	}

}