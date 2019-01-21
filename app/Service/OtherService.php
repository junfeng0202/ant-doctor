<?php
namespace App\Proxy;

use App\Exceptions\ApiException;
use App\Repository\MemberRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Mrgoon\AliSms\AliSms;

class OtherService
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

	public function sendSms($request)
	{
		if(($phone = $request->phone) && preg_match('/^1[356789]\d{9}$/',$phone) ){
			$prefix = config('redisKeys.smsIPSendTime');
			$ipKey = $prefix.$request->getClientIp();
			$phoneKey = $prefix.$phone;
			//短信发送两分钟内限制一次
			if(Redis::exists($phoneKey)) {
				throw new ApiException('短信已发送，请勿重复操作',419);
			}
			if(Redis::get($ipKey) > 20) {
				throw new ApiException('今日短信发送次数已用完',419);
			}

			//手机号已注册
			if((new MemberRepository())->phoneExist($phone)){
				throw new ApiException('手机号已注册',419);
			}

			$code = random_int(10000,99999);
			$response = $this->_sendSms($phone, $code);

			//发送成功，记录当前ip发送的次数
			if($response->Code == 'OK'){
				$this->_cacheData($ipKey, 1, 24*3600);

				$this->_cacheData($phoneKey, 1, 120);

				Cache::put('reg-'.$phone,$code,10);

				return true;

			}else{
				return false;
			}

		}else{
			throw new ApiException('请输入手机号',419);
		}
	}

	public function _cacheData($key, $val, $expire=0)
	{
		if(!Redis::exists($key)){
			$expire ? Redis::setex($key, $expire, $val) : Redis::set($key, $val);
		} else {
			Redis::incr($key);
		}
	}

	protected function _sendSms($phone, $code, $template_id='SMS_154950508')
	{
		return (new AliSms())->sendSms($phone, $template_id, ['code'=>$code]);
	}
}