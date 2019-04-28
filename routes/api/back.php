<?php


/*$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Backend\V1','prefix'=>'back'], function ($api) {
	$api->post('login', 'LoginController@login');
	$api->post('test', 'LoginController@test');
});*/

Route::group(['namespace' => 'App\Http\Controllers\Backend\V1', 'prefix' => 'back'], function () {

	Route::post('login', 'LoginController@login');

	Route::group(['middleware' => 'auth.api'], function () {

		Route::post('/getInfoByToken', 'LoginController@getInfoByToken'); //通过token获取


		Route::group(['middleware' => 'rbac'], function () {
			//素材管理-课程管理
			Route::get('/material/course/list', 'CourseController@list')->name('courseList');
			Route::post('/material/course/create', 'CourseController@create')->name('courseHandle');
			Route::get('/material/course/section/{id}', 'CourseController@sections')->name('courseSection');//获取课程章节
			Route::post('/material/course/section/add/{id}', 'CourseController@addSection')->name('courseSectionHandle');//添加章节
			//素材管理-音频管理
			Route::get('/material/audio/list', 'AudioController@list')->name('audioList');
			Route::post('/material/audio/create', 'AudioController@create')->name('audioHandle');
			Route::get('/material/audio/section/{id}', 'AudioController@sections')->name('audioSection');//获取课程章节
			Route::post('/material/audio/section/add/{id}', 'AudioController@addSection')->name('audioSectionHandle');//添加章节
			//素材管理-图文管理
			Route::get('/material/article/list', 'ArticleController@list')->name('articleList');
			Route::post('/material/article/create', 'ArticleController@create')->name('articleHandle');
			Route::get('/material/article/delete/{id}', 'ArticleController@delete')->name('articleDel');
			//素材管理-直播管理
			Route::get('/material/live/list', 'LiveController@list')->name('liveList');
			Route::post('/material/live/create', 'LiveController@create')->name('liveHandle');
			Route::get('/material/live/delete/{id}', 'LiveController@delete')->name('liveDel');
			//banner管理
			Route::get('/banner/list', 'BannerController@list')->name('bannerList');
			Route::post('/banner/create', 'BannerController@create')->name('bannerHandle');
			Route::post('/banner/delete/{id}', 'BannerController@delete')->name('bannerDel');
			//病种管理
			Route::post('/disease/list', 'DiseaseController@listTree')->name('diseaseList');
			Route::post('/disease/save', 'DiseaseController@save')->name('diseaseHandle');
			Route::post('/disease/delete/{id}', 'DiseaseController@delete')->name('diseaseDel');
			// 角色
			Route::post('/role/list', 'RoleController@getList')->name('roleList');
			Route::post('/role/saveRules', 'RoleController@saveRules')->name('roleRule');
			Route::post('/role/save', 'RoleController@save')->name('roleHandle');
			Route::post('/role/delete/{id}', 'RoleController@delete')->name('roelDel');
			//权限菜单
			Route::post('/rule/list', 'RuleController@getList')->name('ruleList');
			Route::post('/rule/save', 'RuleController@save')->name('ruleHandle');
			Route::post('/rule/delete', 'RuleController@delete')->name('ruleDel');
			//用户列表
			Route::get('/user/list', 'MemberController@list')->name('memberList');
			//讲者管理
			Route::get('/user/doctor/list', 'DoctorController@list')->name('doctorList');
			Route::post('/user/doctor/create', 'DoctorController@create')->name('doctorHandle');
			//管理员
			Route::get('/manager/getList', 'UserController@getList')->name('managerList');
			Route::post('/manager/save', 'UserController@save')->name('managerHandle');
			// 讲堂
			Route::post('/college/list', 'CollegeController@getList')->name('collegeList');
			Route::post('/college/save', 'CollegeController@save')->name('collegeHandle');
			//讲堂频道
			Route::post('/college-section/{id}/list', 'CollegeController@sections')->name('collegeSection');
			Route::post('/college-section/{id}/save', 'CollegeController@sectionSave')->name('collegeSectionHandle');
			//讲堂内容
			Route::post('/college-section-content/{sectionId}/list', 'CollegeController@contents')->name('collegeContent');
			Route::post('/college-section-content/save', 'CollegeController@contentSave')->name('collegeContentHandle');
			Route::post('/college-section-content/{conentId}/delete', 'CollegeController@contentDelete')->name('collegeContentDel');
			//反馈列表
			Route::post('/feedback/list', 'FeedbackController@getList')->name('feedbackList');
			// 订单列表
			Route::post('/order/list', 'OrderController@index')->name('orderList');
			Route::post('/order/refund', 'OrderController@refund')->name('orderRefund');
		});


		Route::get('/material/course/info/{id}', 'CourseController@info');
		Route::get('/material/audio/info/{id}', 'AudioController@info');
		Route::get('/material/article/info/{id}', 'ArticleController@info');
		Route::get('/material/live/info/{id}', 'LiveController@info');

		Route::get('/banner/info/{id}', 'BannerController@info');

		Route::post('/role/info/{id}', 'RoleController@getInfo');
		Route::post('/role/rules', 'RoleController@getRules');

		Route::get('/user/doctor/info/{id}', 'DoctorController@info');

		Route::get('/index/data', 'CommonController@indexData');
		Route::get('/doctor/list', 'CommonController@doctor');

		Route::any('/manager/getInfo/{id}', 'UserController@getInfoById');

		Route::post('/college/info/{id}', 'CollegeController@info');

		Route::post('/college-section/info/{sectionId}', 'CollegeController@sectionInfo');

		Route::post('/college-section-content/{sectionId}/ids', 'CollegeController@contentIds');

		Route::post('/order/statistics', 'OrderController@statistics');

	});
});
