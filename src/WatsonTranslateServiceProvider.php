<?php

namespace FindBrok\WatsonTranslate;

use FindBrok\WatsonBridge\Bridge;
use FindBrok\WatsonTranslate\Contracts\TranslatorInterface;
use FindBrok\WatsonTranslate\Facades\TranslatorFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * Class WatsonTranslateServiceProvider.
 */
class WatsonTranslateServiceProvider extends ServiceProvider
{
    /**
     * Define all Facades here.
     *
     * @var array
     */
    protected $facades = [
        'WatsonTranslate' => TranslatorFacade::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Publish config file
        $this->publishes([
            __DIR__ . '/config/watson-translate.php' => config_path('watson-translate.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Merge config file
        $this->mergeConfigFrom(__DIR__ . '/config/watson-translate.php', 'watson-translate');
        //Register Bindings
        $this->registerBinding();
        //Add Facades to the Translator service
        $this->registerFacades();
    }

    /**
     * Register all bindings in the IOC.
     *
     * @return void
     */
    public function registerBinding()
    {
        //Bind Implementation of the Translator interface
        $this->app->bind(TranslatorInterface::class, config('watson-translate.translator_implementation'));

        //Bind WatsonBridge for WatsonTranslate that we depend on
        $this->app->bind('WatsonTranslateBridge', function () {
            //Return bridge
            return new Bridge(
                config('watson-translate.service_credentials.username'),
                config('watson-translate.service_credentials.password'),
                config('watson-translate.api_endpoint')
            );
        });
    }

    /**
     * Registers all facades.
     *
     * @return void
     */
    public function registerFacades()
    {
        //Register all facades
        collect($this->facades)->each(function ($facadeClass, $alias) {
            //Add Facade
            $this->app->booting(function () use ($alias, $facadeClass) {
                //Get loader instance
                $loader = AliasLoader::getInstance();
                //Add alias
                $loader->alias($alias, $facadeClass);
            });
        });
    }
}
