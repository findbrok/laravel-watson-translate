<?php

namespace FindBrok\WatsonTranslate;

use Illuminate\Support\ServiceProvider;

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
    }
}
