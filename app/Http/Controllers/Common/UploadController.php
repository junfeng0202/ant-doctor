<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\ApiController;
use STS;

class UploadController extends ApiController
{
	protected $config;

	public function __construct()
	{

		$this->config = array(
			'url' => 'https://sts.api.qcloud.com/v2/index.php',
			'domain' => 'sts.api.qcloud.com',
			'proxy' => '',
			'secretId' => config('config.cosSecretId'), // 固定密钥
			'secretKey' => config('config.cosSecretKey'), // 固定密钥
			'bucket' => config('config.cosBucket'), // 换成你的 bucket
			'region' => 'ap-shanghai', // 换成 bucket 所在园区
			'durationSeconds' => 1800, // 密钥有效期
			'allowPrefix' => '*', // 必填，这里改成允许的路径前缀，这里可以根据自己网站的用户登录态判断允许上传的目录，例子：* 或者 a/* 或者 a.jpg
				// 密钥的权限列表
			'allowActions' => array(
				// 所有 action 请看文档 https://cloud.tencent.com/document/product/436/31923
				// 简单上传
				'name/cos:PutObject',
					// 分片上传
				'name/cos:InitiateMultipartUpload',
				'name/cos:ListMultipartUploads',
				'name/cos:ListParts',
				'name/cos:UploadPart',
				'name/cos:CompleteMultipartUpload'
			)
		);
	}

	// 获取临时密钥
	public function getTempKeys(STS $sts)
	{
		return response()->json($sts->getTempKeys($this->config));
	}

}