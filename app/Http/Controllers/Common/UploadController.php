<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\ApiController;
use App\Service\UploadService;

class UploadController extends ApiController
{
	protected $server;

	public function __construct(UploadService $service)
	{
		$this->server = $service;
	}

	public function getTempKeys()
	{
		return $this->apiReturn($this->server->getTempKeys());
	}

}