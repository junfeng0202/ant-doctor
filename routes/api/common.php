<?php
Route::group(['namespace'=>'App\Http\Controllers\Common'], function (){
	Route::any('/wechat', 'WeChatController@serve');
	Route::any('/wechat/addmenu', 'WeChatController@addMenu');
	Route::any('/wechat/getusers', 'WeChatController@getUsers');
});

Route::group(['namespace'=>'App\Http\Controllers\Common','prefix'=>'v1'], function () {
	Route::get('wechat/getCode', 'WeChatController@getCode');
	Route::post('wechat/user', 'WeChatController@user');

	Route::get('disease', 'CommonController@disease');
	Route::get('province', 'CommonController@province');
	Route::post('sms', 'CommonController@sms');

	Route::post('/cos/getTempKeys', 'UploadController@getTempKeys');
});
