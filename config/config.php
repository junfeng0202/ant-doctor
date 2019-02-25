<?php

return [
	'frontend_client'=>env('FRONT_CLIENT_ID'),
	'backend_client_id'=>env('BACKEND_CLIENT_ID'),
	'backend_client_secret'=>env('BACKEND_CLIENT_SECRET'),

	//腾讯点播appID
	'appID'=>'1252490301',

	'sms_forget_prefix'=>'for-',
	'sms_register_prefix'=>'reg-',

	'openssl_key'=>env('OPENSSL_KEY',''),

	'openssl_iv'=>env('OPENSSL_IV',''),

	'doctor_url'=>env('DOCTOR_URL',''),
];
