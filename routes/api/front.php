<?php

/*Route::middleware('auth:member')->get('/user', function (Request $request) {
    return auth('member')->user();
});*/

Route::group(['namespace'=>'App\Http\Controllers\Frontend\V1','prefix' => 'v1'], function () {

	Route::post('login', 'LoginController@login');
	Route::any('register', 'LoginController@register');
	Route::post('logout', 'LoginController@logout');
	Route::post('refresh', 'LoginController@refresh');

	Route::post('user', 'MemberController@user');
	Route::post('edit-info', 'MemberController@editInfo');


	//首页获取数据
	Route::get('index', 'IndexController@index');

	Route::get('article', 'ArticleController@index');
	Route::get('article/{id}', 'ArticleController@info')->name('article.info');

	Route::get('course', 'CourseController@index');
	Route::get('course/{id}', 'CourseController@info')->name('course.info');
	Route::get('course-section/{id}', 'CourseController@section')->name('course.section');
	Route::get('course-audio/{id}', 'CourseController@audio')->name('course.audio');

	Route::get('live', 'LiveController@index');
	Route::get('live/{id}', 'LiveController@info')->name('live.info');

	Route::get('video', 'VideoController@index');
	Route::get('video/{id}', 'VideoController@info')->name('video.info');
	Route::get('video-section/{id}', 'VideoController@section')->name('video.section');


});