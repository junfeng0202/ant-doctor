<?php

Route::group(['namespace'=>'App\Http\Controllers\Frontend\V1'], function () {
	Route::post('/aliNotify', 'PayController@aliNotify');
	Route::post('/wechatNotify', 'PayController@wechatNotify');
});

Route::group(['namespace'=>'App\Http\Controllers\Frontend\V1','prefix' => 'v1'], function () {

	Route::post('login', 'LoginController@login');
	Route::post('forget', 'LoginController@forget');
	Route::post('register', 'LoginController@register');
	Route::post('refresh', 'LoginController@refresh');
	Route::post('wechatLogin', 'LoginController@loginByOpenid');

	Route::group(['middleware'=>'jwt.auth'],function (){
		Route::post('logout', 'LoginController@logout');

		Route::post('course-study', 'CourseController@study');

		Route::post('edit-info', 'MemberController@editInfo');
		Route::post('study-history', 'MemberController@studyHistory');
		Route::post('user', 'MemberController@user');

		//反馈
		Route::post('user/feedback', 'MemberController@feedback');

		Route::post('user/orders', 'MemberController@orders');

		// 提交订单
		Route::any('order/college/{id}', 'OrderController@createCollegeOrder');
		Route::post('order/course/{id}', 'OrderController@createCourseOrder');
		Route::post('order/video/{id}', 'OrderController@createVideoOrder');
		// 支付页面
		Route::post('order/topay/{id}', 'OrderController@orderInfo');
		Route::post('order/cancel', 'OrderController@cancelOrder');

	});



	//首页获取数据
	Route::get('index', 'IndexController@index');
	Route::post('search', 'IndexController@search');

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

	//讲堂
	Route::any('colleges', 'CollegeController@getList')->name('college.list');
	Route::get('college/{id}', 'CollegeController@info')->name('college.info');
	Route::get('college/sectionContents/{sectionId}', 'CollegeController@sectionContents')->name('college.sectionContents');
	Route::get('college/card/{id}', 'CollegeController@collegeCard');

	Route::get('pay', 'PayController@index');
	Route::post('pay/success', 'PayController@success');

});
