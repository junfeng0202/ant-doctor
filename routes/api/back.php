<?php


/*$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Backend\V1','prefix'=>'back'], function ($api) {
	$api->post('login', 'LoginController@login');
	$api->post('test', 'LoginController@test');
});*/

Route::group(['namespace'=>'App\Http\Controllers\Backend\V1', 'prefix'=>'back'], function (){

	Route::post('login', 'LoginController@login');

	Route::group(['middleware'=>'auth.api'], function(){

		Route::post('/getInfoByToken', 'LoginController@getInfoByToken'); //通过token获取
		//素材管理-课程管理
		Route::get('/material/course/list', 'CourseController@list');
		Route::get('/material/course/info/{id}', 'CourseController@info');
		Route::post('/material/course/create', 'CourseController@create');
		Route::get('/material/course/sections/{id}', 'CourseController@sections');//获取课程章节
		Route::post('/material/course/section/add/{id}', 'CourseController@addSection');//添加章节

		//素材管理-音频管理
		Route::get('/material/audio/list', 'AudioController@list');
		Route::get('/material/audio/info/{id}', 'AudioController@info');
		Route::post('/material/audio/create', 'AudioController@create');
		Route::get('/material/audio/sections/{id}', 'AudioController@sections');//获取课程章节
		Route::post('/material/audio/section/add/{id}', 'AudioController@addSection');//添加章节

		//素材管理-图文管理
		Route::get('/material/article/list', 'ArticleController@list');
		Route::get('/material/article/info/{id}', 'ArticleController@info');
		Route::post('/material/article/create', 'ArticleController@create');
		Route::get('/material/article/delete/{id}', 'ArticleController@delete');

		//素材管理-直播管理
		Route::get('/material/live/list', 'LiveController@list');
		Route::get('/material/live/info/{id}', 'LiveController@info');
		Route::post('/material/live/create', 'LiveController@create');
		Route::get('/material/live/delete/{id}', 'LiveController@delete');

		//系统管理-banner管理
		Route::get('/system/banner/list', 'BannerController@list');
		Route::get('/system/banner/info/{id}', 'BannerController@info');
		Route::post('/system/banner/create', 'BannerController@create');
		Route::get('/system/banner/delete/{id}', 'BannerController@delete');

		//系统管理-病种管理
		Route::post('/diseases/delete/{id}', 'DiseaseController@delete');
		Route::post('/disease/list', 'DiseaseController@listTree');
		Route::post('/disease/save', 'DiseaseController@save');

		//用户管理
		//用户列表
		Route::get('/user/list', 'MemberController@list');


		//讲者管理
		Route::get('/user/doctor/list', 'DoctorController@list');
		Route::get('/user/doctor/info/{id}', 'DoctorController@info');
		Route::post('/user/doctor/create', 'DoctorController@create');

		Route::get('/index/data', 'CommonController@indexData');
		Route::get('/doctor/list', 'CommonController@doctor');


		//管理员
		Route::get('/manager/getList', 'UserController@getList'); //通过id获取
		Route::any('/manager/getInfo/{id}', 'UserController@getInfoById'); //通过id获取
		Route::post('/manager/save', 'UserController@save');

		// 讲堂
		Route::post('/college/list', 'CollegeController@getList');
		Route::post('/college/info/{id}', 'CollegeController@info');
		Route::post('/college/save', 'CollegeController@save');
		//讲堂频道
		Route::post('/college-section/{id}/list', 'CollegeController@sections');
		Route::post('/college-section/info/{sectionId}', 'CollegeController@sectionInfo');
		Route::post('/college-section/{id}/save', 'CollegeController@sectionSave');
		//讲堂内容
		Route::post('/college-section-content/{sectionId}/list', 'CollegeController@contents');
		Route::post('/college-section-content/{sectionId}/ids', 'CollegeController@contentIds');
		Route::post('/college-section-content/save', 'CollegeController@contentSave');
		Route::post('/college-section-content/{conentId}/delete', 'CollegeController@contentDelete');

		//反馈列表
		Route::post('/feedback/list', 'FeedbackController@getList');
	});


});
