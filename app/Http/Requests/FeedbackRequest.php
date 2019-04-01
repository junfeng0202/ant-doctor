<?php

namespace App\Http\Requests;


class FeedbackRequest extends BaseRequest
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
		    'type' => ['required'],
		    'content' => ['required'],
		    'images'=>'sometimes|required|array'
	    ];
    }

    public function messages()
    {
	    return [
		    'type.required'=>'请选择反馈类型',
		    'content.required'=>'请填写要描述的内容',
	    ];
    }

}
