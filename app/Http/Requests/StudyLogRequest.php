<?php

namespace App\Http\Requests;

class StudyLogRequest extends BaseRequest
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
            'course_id'=>'required',
            'course_section_id'=>'required',
            'time'=>'required',
            'end'=>'required',
        ];
    }

    public function messages()
    {
	    return [
	    	'course_id.required'=>'course id need',
	    	'course_section_id.required'=>'course section id need',
	    	'time.required'=>'time need',
	    	'end.required'=>'status need',

	    ];
    }

}
