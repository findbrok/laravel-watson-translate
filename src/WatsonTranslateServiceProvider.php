<?php

namespace FindBrok\WatsonTranslate;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

/**
 * Class WatsonTranslateServiceProvider
 * @package FindBrok\WatsonTranslate
 */
class WatsonTranslateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Publish config file
        $this->publishes([
            __DIR__.'/config/watson-translate.php' => config_path('watson-translate.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Merge config file
        $this->mergeConfigFrom(
            __DIR__.'/config/watson-translate.php', 'watson-translate'
        );

        //Bind Implementation of the Translator interface
        $this->app->bind('FindBrok\WatsonTranslate\Contracts\TranslatorInterface', config('watson-translate.translator_implementation'));
        //Add Facade to the Translator service
        $this->app->booting(function () {
            //Get loader instance
            $loader = AliasLoader::getInstance();
            //Add alias
            $loader->alias('WatsonTranslate', 'FindBrok\WatsonTranslate\Facades\TranslatorFacade');
        });
    }
}
