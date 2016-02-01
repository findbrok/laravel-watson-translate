# Laravel 5 IBM Watson Translate

This package provides an api to perform translations using the IBM Watson Language Translation service. 

To get a better understand of how this package work read the docs for Watson Language Translation service first.

- [Getting started with the Language Translation service](https://www.ibm.com/smarterplanet/us/en/ibmwatson/developercloud/doc/language-translation/)
- [API Explorer](https://watson-api-explorer.mybluemix.net/apis/language-translation-v2)
- [API reference](https://www.ibm.com/smarterplanet/us/en/ibmwatson/developercloud/language-translation/api/v2/)

## Installation
Begin by installing this package through Composer.

```php
{
    "require": {
        "findbrok/laravel-watson-translate": "~1.0"
    }
}
```

Add the WatsonTranslateServiceProvider to your provider array

```php
// config/app.php

'providers' => [
    ...
    FindBrok\WatsonTranslate\WatsonTranslateServiceProvider::class,
];
```

## Configuration

First publish the configuration file

```php
php artisan vendor:publish --provider="FindBrok\WatsonTranslate\WatsonTranslateServiceProvider"
```

Set your correct credentials and default configuration for using your IBM Watson Language translation service 
> config/watson-translate.php

## Usage

Read the [Docs](https://github.com/findbrok/laravel-watson-translate/wiki)