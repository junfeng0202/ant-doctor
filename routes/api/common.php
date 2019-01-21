<?php
Route::group(['namespace'=>'App\Http\Controllers\Common'], function (){
	Route::any('/wechat', 'WeChatController@serve');
});

Route::group(['namespace'=>'App\Http\Controllers\Common','prefix'=>'v1'], function () {
	Route::get('disease', 'CommonController@disease');
	Route::get('province', 'CommonController@province');
	Route::post('sms', 'CommonController@sms');
});
