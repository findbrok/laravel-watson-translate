# Laravel 5 IBM Watson Translate
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5383ddb7-8c07-433e-98c0-0cda2eedba76/big.png)](https://insight.sensiolabs.com/projects/5383ddb7-8c07-433e-98c0-0cda2eedba76)

[![StyleCI](https://styleci.io/repos/50762162/shield?style=flat)](https://styleci.io/repos/50762162)
[![Build Status](https://travis-ci.org/findbrok/laravel-watson-translate.svg?branch=master)](https://travis-ci.org/findbrok/laravel-watson-translate)
[![Latest Stable Version](https://poser.pugx.org/findbrok/laravel-watson-translate/v/stable)](https://packagist.org/packages/findbrok/laravel-watson-translate) 
[![Total Downloads](https://poser.pugx.org/findbrok/laravel-watson-translate/downloads)](https://packagist.org/packages/findbrok/laravel-watson-translate) 
[![Latest Unstable Version](https://poser.pugx.org/findbrok/laravel-watson-translate/v/unstable)](https://packagist.org/packages/findbrok/laravel-watson-translate) 
[![License](https://poser.pugx.org/findbrok/laravel-watson-translate/license)](https://packagist.org/packages/findbrok/laravel-watson-translate)

This package provides a simple api to perform translations using the IBM Watson Language Translation service. 

To get a better understanding of how this package works read the documentation for Watson Language Translation service first.

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

Add the WatsonTranslateServiceProvider to your providers array

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

## TODO

- [ ] Create Translation Model
- [ ] Delete Translation Model

## Credits

[![Percy Mamedy](https://img.shields.io/badge/Author-Percy%20Mamedy-orange.svg)](https://twitter.com/PercyMamedy)

Twitter: [@PercyMamedy](https://twitter.com/PercyMamedy)
<br/>
GitHub: [percymamedy](https://github.com/percymamedy)
