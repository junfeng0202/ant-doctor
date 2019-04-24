<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		ApiException::class
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * @param  \Exception $exception
	 * @return void
	 */
	public function report(Exception $exception)
	{
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($e instanceof HttpResponseException) {
			$message = $e->getMessage() ?: 'http response error';
			$code = $e->getCode() ?: 400;
			return response()->json(['message' => $message, 'code' => $code, 'data' => []]);

		}elseif ($e instanceof ValidationException) {
			$message = $e->getMessage() ?: 'validation failed';
			$code = $e->getCode() ?: 419;
			return response()->json(['message' => $message, 'code' => $code, 'data' => []]);

		}elseif ($e instanceof UnauthorizedHttpException) {
			$message = $e->getMessage() ?: 'token_expired';
			$code = $e->getCode() ?: 401;
			return response()->json(['message' => $message, 'code' => $code, 'data' => []]);

		}elseif ($e instanceof MethodNotAllowedHttpException) {
			$message = $e->getMessage() ?: 'http method error';
			$code = $e->getCode() ?: 405;
			return response()->json(['message' => $message, 'code' => $code, 'data' => []]);

		}elseif ($e instanceof ModelNotFoundException) {
			// 如果删除的内容已经不存在了，就没必要报错了，直接成功处理
			if ($request->isMethod('delete')) {
				return response()->json(['msg' => '', 'code' => 200, 'data' => []]);
			}

			return response()->json(['msg' => '页面未找到', 'code' => 404, 'data' => []]);

		}elseif ($e instanceof ApiException) {
			return response()->json(['msg' => $e->getMessage(), 'code' => 419, 'data' => []]);
		}

		return response()->json(['msg' => $e->getMessage(), 'code' => 500, 'data' => []]);
	}

}
