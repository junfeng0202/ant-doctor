<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	        'username' => 'required',
	        'password' => 'required',
	        'code' => 'required',
        ];
    }

    public function messages()
    {
	    return [
	    	'username.required'=>'用户名不能为空',
	    	'password.required'=>'密码不能为空',
	    	'code.required'=>'请输入验证码',
	    ];
    }
}
