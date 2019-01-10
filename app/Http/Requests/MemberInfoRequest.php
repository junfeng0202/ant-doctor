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
        ];
    }

}
