<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
	const result = [
		'0'=>['code'=>500, 'msg'=>'系统繁忙'],
		'1'=>['code'=>200, 'msg'=>'操作成功'],
		'10'=>['code'=>200, 'msg'=>'登入成功'],
		'11'=>['code'=>200, 'msg'=>'注册成功'],
		'100'=>['code'=>419, 'msg'=>'用户名或密码错误'],
		'101'=>['code'=>502, 'msg'=>'注册失败'],
		'102'=>['code'=>200, 'msg'=>'发送成功'],
		'103'=>['code'=>501, 'msg'=>'发送失败'],
		'104'=>['code'=>200, 'msg'=>'logout Successfully'],
		'105'=>['code'=>200, 'msg'=>'密码修改成功'],
		'106'=>['code'=>500, 'msg'=>'退款失败'],
	];

	protected $index=1;



	/**
	 * @return mixed
	 */
	public function getIndex()
	{
		return $this->index;
	}

	/**
	 * @param mixed $index
	 */
	public function setIndex($index)
	{
		$this->index = $index;
		return $this;
	}

	public function apiReturn($data=[])
	{
		$msg = self::result[$this->getIndex()];
		return response()->json(array_merge($msg,['data'=>$data]));
	}

}
