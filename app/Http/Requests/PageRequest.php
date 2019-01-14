<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends BaseRequest
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
	        'page' => ['required'],
	        'page_limit' => ['required']
        ];
    }

    public function messages()
    {
	    return [
	    	'page.required'=>'分页参数：page不能为空',
	    	'page_limit.required'=>'分页参数：page_limit不能为空',
	    ];
    }
}
