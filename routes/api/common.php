<?php
/*Route::group(['namespace'=>'App\Http\Controllers\Common'], function (){
	Route::get('disease', 'CommonController@disease');
	Route::get('province', 'CommonController@province');
});*/

Route::group(['namespace'=>'App\Http\Controllers\Common'], function () {
	Route::get('disease', 'CommonController@disease');
	Route::get('province', 'CommonController@province');

	//获取蚂蚁信息列表
	Route::get('articlesList', 'CommonController@articlesList');

});
