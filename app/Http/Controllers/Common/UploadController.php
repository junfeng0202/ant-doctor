<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\ApiController;

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
	protected function _hex2bin($data) {
		$len = strlen($data);
		return pack("H" . $len, $data);
	}


	// obj 转 query string
	protected function json2str($obj, $notEncode = false) {
		ksort($obj);
		$arr = array();
		foreach ($obj as $key => $val) {
			array_push($arr, $key . '=' . ($notEncode ? $val : rawurlencode($val)));
		}
		return join('&', $arr);
	}

	// 计算临时密钥用的签名
	protected function getSignature($opt, $key, $method, $domain) {
		$formatString = $method . $domain . '/v2/index.php?' . $this->json2str($opt, 1);
		$sign = hash_hmac('sha1', $formatString, $key);
		$sign = base64_encode($this->_hex2bin($sign));
		return $sign;
	}

	// 获取临时密钥
	public function getTempKeys() {
		$ShortBucketName = substr($this->config['bucket'],0, strripos($this->config['bucket'], '-'));
		$AppId = substr($this->config['bucket'], 1 + strripos($this->config['bucket'], '-'));
		$policy = array(
			'version'=> '2.0',
			'statement'=> array(
				array(
					'action'=> $this->config['allowActions'],
					'effect'=> 'allow',
					'principal'=> array('qcs'=> array('*')),
					'resource'=> array(
						'qcs::cos:' . $this->config['region'] . ':uid/' . $AppId . ':prefix//' . $AppId . '/' . $ShortBucketName . '/' . $this->config['allowPrefix']
					)
				)
			)
		);
		$policyStr = str_replace('\\/', '/', json_encode($policy));
		$Action = 'GetFederationToken';
		$Nonce = rand(10000, 20000);
		$Timestamp = time();
		$Method = 'POST';
		$params = array(
			'Region'=> 'gz',
			'SecretId'=> $this->config['secretId'],
			'Timestamp'=> $Timestamp,
			'Nonce'=> $Nonce,
			'Action'=> $Action,
			'durationSeconds'=> $this->config['durationSeconds'],
			'name'=> 'cos',
			'policy'=> urlencode($policyStr)
		);
		$params['Signature'] = $this->getSignature($params, $this->config['secretKey'], $Method, $this->config['domain']);
		$url = $this->config['url'];
		$ch = curl_init($url);
		$this->config['proxy'] && curl_setopt($ch, CURLOPT_PROXY, $this->config['proxy']);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->json2str($params));
		$result = curl_exec($ch);
		if(curl_errno($ch)) $result = curl_error($ch);
		curl_close($ch);
		$result = json_decode($result, 1);
		if (isset($result['data'])) {
			$result = $result['data'];
			$result['startTime'] = $result['expiredTime'] - $this->config['durationSeconds'];
		}
		return response()->json($result);
	}




}