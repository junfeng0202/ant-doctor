<?php
Route::group(['namespace'=>'App\Http\Controllers\Common'], function (){

	Route::any('/wechat', 'WeChatController@serve'); //微信消息服务

	//前台接口
	Route::group(['prefix'=>'v1'], function () {
		Route::get('wechat/getCode', 'WeChatController@getCode');
		Route::post('wechat/user', 'WeChatController@user');
		// 医学V授权
		Route::get('wechat/getVCode', 'WeChatController@getVCode');
		Route::post('wechat/userV', 'WeChatController@userV');

		Route::get('disease', 'CommonController@disease');
		Route::post('topDisease', 'CommonController@topDisease');

		Route::get('province', 'CommonController@province');
		Route::post('sms', 'CommonController@sms');

		Route::post('/cos/getTempKeys', 'UploadController@getTempKeys');
	});

	//后台接口
	Route::group(['prefix'=>'back','middleware'=>'auth.api'], function (){
		Route::post('/wechat/updateMenu', 'WeChatController@updateMenu')->name('wechatHandle')->middleware('rbac'); // 设置更新菜单
		Route::get('/wechat/synMenu', 'WeChatController@synMenu'); // 手动更新菜单
		Route::post('/wechat/getMenu', 'WeChatController@getMenu')->name('weChatList')->middleware('rbac'); // 获取菜单列表
		Route::any('/wechat/getusers', 'WeChatController@getUsers'); // 通过access_token获取微信用户信息
		Route::any('/wechat/materials/{type?}', 'WeChatController@materials'); // 获取微信素材列表
		Route::any('/wechat/materialAdd', 'WeChatController@materialAdd'); // 获取微信素材列表
		Route::any('/wechat/imageUpload', 'WeChatController@imageUpload'); // 获取微信素材列表

		Route::post('/cos/getTempKeys', 'UploadController@getTempKeys');

		Route::post('topDisease', 'CommonController@topDisease');
	});
});


