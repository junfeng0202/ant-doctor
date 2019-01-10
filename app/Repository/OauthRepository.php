<?php

namespace App\Repository;


use App\Models\OauthClient;

class OauthRepository
{
	public function getOne($id)
	{
		return OauthClient::find($id);
	}
}