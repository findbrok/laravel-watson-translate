<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Service credentials
    |--------------------------------------------------------------------------
    |
    | Set these values to your service own service credentials that you
	| obtained when registering for Watson Language translation service.
    |
    */
	'service_credentials' => [
		'username' => env('WATSON_TRANSLATE_USERNAME', 'SomeUsername'),
		'password' => env('WATSON_TRANSLATE_PASSWORD', 'SomePassword'),
	],
];