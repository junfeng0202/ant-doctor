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

	public function proxy($grantType, Array $data=[])
	{


		$response = $this->client->post(config('app.url').'/oauth/token', [
			'form_params' => array_merge(['grant_type' => $grantType], $data)
		]);
		return json_decode((string) $response->getBody(), true);
	}
}
