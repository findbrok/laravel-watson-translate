<?php

namespace FindBrok\WatsonTranslate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class TranslatorFacade
 * @package FindBrok\WatsonTranslate\Facades
 */
class TranslatorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'FindBrok\WatsonTranslate\Contracts\TranslatorInterface';
    }
}
