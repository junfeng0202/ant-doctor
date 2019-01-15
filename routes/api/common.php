<?php
/*Route::group(['namespace'=>'App\Http\Controllers\Common'], function (){
	Route::get('disease', 'CommonController@disease');
	Route::get('province', 'CommonController@province');
});*/

Route::group(['namespace'=>'App\Http\Controllers\Common','prefix'=>'v1'], function () {
	Route::get('disease', 'CommonController@disease');
	Route::get('province', 'CommonController@province');


});
