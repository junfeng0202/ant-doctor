<?php

namespace App\Http\Requests;

class VideoRequest extends BaseRequest
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
	        'title' => 'required',
	        'doctor_ids' => 'required|array',
	        'disease_id' => 'required',
	        'image' => 'required',
	        'price' => 'required',
	        'active_start_at' => 'required_if:active_on,1',
	        'active_end_at' => 'required_if:active_on,1',
        ];
    }

    public function messages()
    {
	    return [
	    	'title.required'=>'请输入课程标题',
	    	'doctor_ids.required'=>'请选择讲师',
	    	'disease_id.required'=>'请选择病种',
	    	'image.required'=>'请上传图片',
	    	'price.required'=>'请输入售价',
	    	'active_start_at.required_if'=>'请选择活动开始时间',
	    	'active_end_at.required_if'=>'请选择活动结束时间',
	    ];
    }
}
