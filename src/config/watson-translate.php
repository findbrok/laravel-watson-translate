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

	/*
    |--------------------------------------------------------------------------
    | API EndPoint
    |--------------------------------------------------------------------------
    |
    | Set api endpoint for Watson Language Translation service
    |
    */
	'api_endpoint' => env('WATSON_TRANSLATE_API_ENDPOINT', 'https://gateway.watsonplatform.net/language-translation/api/'),

	/*
    |--------------------------------------------------------------------------
    | X-Watson-Learning-Opt-Out
    |--------------------------------------------------------------------------
    |
    | By default, Watson collects data from all requests and uses the data to improve the service.
	| If you do not want to share your data, set this value to true.
    |
    */
	'x_watson_learning_opt_out' => false,

	/*
    |--------------------------------------------------------------------------
    | Translator Implementation
    |--------------------------------------------------------------------------
    |
    | By default the interface is implemented by FindBrok\WatsonTranslate\Translator
	| Change this value to your own implementation if you wish to override the
	| implementation of the Translator interface
    |
    */
	'translator_implementation' => 'FindBrok\WatsonTranslate\Translator',

	/*
    |--------------------------------------------------------------------------
    | Translations Models
    |--------------------------------------------------------------------------
    |
    | Here you may specify a name to give to each Watson Language translation
	| Service models to be used. You will use these model names instead of their
	| id when performing translations. Feel free to add as many models as you want
	| and give any name that you see fit.
    |
    */
	'models' => [
		'default' => env('WATSON_TRANSLATE_DEFAULT_MODEL', 'en-fr')
	],
];