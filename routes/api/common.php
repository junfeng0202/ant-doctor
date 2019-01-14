<?php
Route::group(['namespace'=>'App\Http\Controllers\Common'], function (){
	Route::get('disease', 'CommonController@disease');
	Route::get('province', 'CommonController@province');
});


/*$api = app('Dingo\Api\Routing\Router');

$api->group(['namespace'=>'App\Http\Controllers\Common'], function ($api) {
	$api->get('disease', 'CommonController@disease');
	$api->get('province', 'CommonController@province');
});*/
