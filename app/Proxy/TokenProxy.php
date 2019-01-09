<?php
namespace App\Proxy;

use GuzzleHttp\Client;

class TokenProxy
{
	const FRONTEND=1;
	const BACKEND=2;

	protected $client;


	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	public function proxy($grantType, $plat, Array $data=[])
	{
		//不同平台加载不同配置
		switch ($plat){
			case self::FRONTEND:
				$clientData = [
					'client_id' => config('config.frontClientId'),
					'client_secret' =>  config('config.frontClientSecret'),
				];break;
			case self::BACKEND:
				$clientData = [
					'client_id' => config('config.backClientId'),
					'client_secret' =>  config('config.backClientSecret'),
				];break;
			default:
				$clientData = [];
		}
		$params = [
			'grant_type' => $grantType,
			'email' => $data['username'],
			'password' => $data['password'],
			'scope' => '',
		];
		$response = $this->client->post(config('app.url').'/oauth/token', [
			'form_params' => array_merge($params,$clientData)
		]);
		return json_decode((string) $response->getBody(), true);
	}
}
