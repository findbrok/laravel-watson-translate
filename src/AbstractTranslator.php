<?php

namespace FindBrok\WatsonTranslate;

use FindBrok\WatsonTranslate\Presenters\ResultsCollection;

/**
 * Class AbstractTranslator
 * @package FindBrok\WatsonTranslate
 */
abstract class AbstractTranslator
{
    /**
     * Translator's traits
     */
    use ResultsCollection;

    /**
     * The results from API
     *
     * @var string
     */
    protected $results = null;

    /**
     * The language from which we are translating
     *
     * @var string
     */
    protected $from = null;

    /**
     * The language to which we want to get results
     *
     * @var string
     */
    protected $to = null;

    /**
     * The model Id we want to use for translation
     *
     * @var string
     */
    protected $modelId = null;

    /**
     * Request Headers
     *
     * @var array
     */
    protected $headers = [
        'Accept' => 'application/json'
    ];

    /**
     * Getting attributes
     *
     * @param $variable
     * @return mixed
     */
    public function __get($attribute)
    {
        //Attributes exists
        if (property_exists($this, $attribute)) {
            //return the attribute value
            return $this->$attribute;
        }
        //We return null
        return null;
    }

    /**
     * Append Headers to request
     *
     * @param array $headers
     * @return self
     */
    public function appendHeaders($headers = [])
    {
        //Append headers
        $this->headers = collect($this->headers)->merge($headers)->all();
        //Return calling object
        return $this;
    }

    /**
     * Return the headers used for making request
     *
     * @return array
     */
    private function getHeaders()
    {
        //Return headers
        return collect($this->headers)->merge([
            'X-Watson-Learning-Opt-Out' => config('watson-translate.x_watson_learning_opt_out')
        ])->all();
    }

    /**
     * Make a Bridge to Send API Request to Watson
     *
     * @return \FindBrok\WatsonBridge\Bridge
     */
    public function makeBridge()
    {
        return app()->make('WatsonTranslateBridge')->appendHeaders($this->getHeaders());
    }

    /**
     * Return the results from API
     *
     * @return string|null
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Return Model id to Use
     *
     * @return string|null
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * Set the language code of the language
     * we are translating from
     *
     * @param string $lang
     * @return self
     */
    public function from($lang = '')
    {
        //Set the language from code
        $this->from = $lang;
        //return the translator
        return $this;
    }

    /**
     * Set the language code of the language
     * we are translating to
     *
     * @param string $lang
     * @return self
     */
    public function to($lang = '')
    {
        //Set the language to code
        $this->to = $lang;
        //return the translator
        return $this;
    }

    /**
     * Set the model id of the model we want to use
     * for translation, overrides to and from
     *
     * @param string $modelName
     * @return self
     */
    public function usingModel($modelName = '')
    {
        //Set the model id
        $this->modelId = ($modelName == '') ?
                         config('watson-translate.models.default') :
                         config('watson-translate.models.'.$modelName);
        //return the translator
        return $this;
    }
}
