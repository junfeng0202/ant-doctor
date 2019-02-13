<?php

namespace App\Http\Middleware;

use App\Models\Member;
use Closure;
use Session;

class GetOpenid
{
    /**
     * 移动端验证登录状态
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    if (!Session::has('member_id')) {
		    // 记录要回跳的页面
		    if($request->get('back_url') !== 'ignore')
		        Session::put('return_referer', $request->getRequestUri());

		    // 如果是微信端访问，获取unionid
		    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {

			    if (!$request->session()->exists('openid')) {
				    //Session::put('getOpenId', 1);
				    $app = app('wechat.official_account');
				    return $app->oauth->scopes(['snsapi_userinfo'])->redirect();
			    } else {
				    $openid = $request->session()->get('openid');
				    // 如果unionid存在，使用unionid登入
				    $member = Member::where(['open_id' => $openid])->first();
				    // 如果微信号已经和账号绑定，记录session
				    if ($member) {
					    LoginService::memberSession($member);
					    session(['return_referer' => null]);
				    }
			    }

		    }

	    }
        return $next($request);
    }
}
