<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BaseRequest extends FormRequest
{
	protected function failedValidation(Validator $validator)
	{
		throw new HttpException(420, $validator->errors()->first());
	}
}
