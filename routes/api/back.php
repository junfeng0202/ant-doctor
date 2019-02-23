<?php


/*$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Backend\V1','prefix'=>'back'], function ($api) {
	$api->post('login', 'LoginController@login');
	$api->post('test', 'LoginController@test');
});*/

Route::group(['namespace'=>'App\Http\Controllers\Backend\V1','prefix'=>'back'], function (){
	Route::post('login', 'LoginController@login');
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

    //素材管理-直播管理
    Route::get('/material/live/list', 'LiveController@list');
    Route::get('/material/live/info/{id}', 'LiveController@info');
    Route::post('/material/live/create', 'LiveController@create');

    //系统管理-banner管理
    Route::get('/system/banner/list', 'BannerController@list');
    Route::get('/system/banner/info/{id}', 'BannerController@info');
    Route::post('/system/banner/create', 'BannerController@create');

    //用户管理
    //用户列表
    Route::get('/user/list', 'UserController@list');
    //讲者管理
    Route::get('/user/doctor/list', 'DoctorController@list');
    Route::get('/user/doctor/info/{id}', 'DoctorController@info');
    Route::post('/user/doctor/create', 'DoctorController@create');

    Route::get('/index/data', 'CommonController@indexData');
    Route::get('/doctor/list', 'CommonController@doctor');
	Route::get('/disease/list', 'CommonController@disease');
	Route::get('/upload/getTempKeys', 'CommonController@getTempKeys');

});
