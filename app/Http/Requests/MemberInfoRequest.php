<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identify'=>'required',
            'gender'=>'required|in:0,1,2',
            'birth'=>'required',
            'province_id'=>'required|numeric',
            'city_id'=>'required|numeric',
            'disease'=>'required|array',
        ];
    }

    public function messages()
    {
	    return [
	    	'identify.required'=>'请选择身份',
	    	'gender.required'=>'请选择性别',
	    	'gender.in'=>'无效的性别',
	    	'birth.required'=>'请选择出生日期',
	    	'province_id.required'=>'请选择省市',
	    	'city_id.required'=>'请选择城市',
	    	'disease.required'=>'请选择感兴趣的疾病',
	    ];
    }

}
