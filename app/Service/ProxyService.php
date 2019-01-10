<?php
namespace App\Proxy;

use GuzzleHttp\Client;

class ProxyService
{
	const FRONTEND=1;
	const BACKEND=2;


	public function proxy($grantType, Array $data=[])
	{

		$response = (new Client)->post(config('app.url').'/oauth/token', [
			'form_params' => array_merge(['grant_type' => $grantType], $data)
		]);
		return json_decode((string) $response->getBody(), true);
	}
}
