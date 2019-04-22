<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class checkRbac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$user = Auth::guard('api')->user();
    	if(!$user->is_admin) {
		    $rules = Cache::tags('rules')->get(config('config.rule_key').$user->id);
		    if (!in_array($request->route()->getName(), $rules)) {
			    return response()->json(['code'=>4003, 'msg'=>'无操作权限']);
		    }
	    }

        return $next($request);
    }
}
