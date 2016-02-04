<?php

namespace FindBrok\WatsonTranslate\Presenters;

/**
 * Class ResultsCollection
 * @package FindBrok\WatsonTranslate\Presenters
 */
trait ResultsCollection
{
    /**
     * Returns the raw results from the request
     *
     * @return string
     */
    public function rawResults()
    {
        //Return raw results
        return $this->results;
    }

    /**
     * Returns the results of the response as a collection
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function collectResults()
    {
        //Return response as collection or null if not set
        return ($this->arrayResults() != null)?collect($this->arrayResults()):null;
    }

    /**
     * Returns the results of the response array
     *
     * @return array|null
     */
    public function arrayResults()
    {
        //return response as array or null
        return ($this->results != null)?json_decode($this->results, true):null;
    }

    /**
     * Returns only the translations from results
     *
     * @param bool|false $asCollection
     * @return mixed
     */
    public function getTranslation($asCollection = false)
    {
        //We do not have a response
        if($this->getResponse() == null || $this->collectResults()->get('translations') == null) {
            //We return null only
            return null;
        }
        //We have more than one translation
        if(count($this->collectResults()->get('translations')) > 1) {
            //Get only translations
            $translations = collect($this->collectResults()->get('translations'))->transform(function($item) {
                return $item['translation'];
            });
            //Return the translations as array or collection
            return ($asCollection)?$translations:$translations->all();
        } else {
            //Return the single translation as collection or string
            return ($asCollection)?collect($this->collectResults()->get('translations')):collect(collect($this->collectResults()->get('translations'))->first())->get('translation');
        }
    }

    /**
     * Return languages names only
     *
     * @param bool $asCollection
     * @return mixed
     */
    public function languagesNames($asCollection = false)
    {
        //We do not have a response
        if($this->getResponse() == null || $this->collectResults()->get('languages') == null) {
            //We return null only
            return null;
        }
        //Get languages name only
        $languagesName = collect($this->collectResults()->get('languages'))->transform(function($item) {
            return isset($item['name'])?$item['name']:null;
        })->reject(function($item) {
            return $item == null;
        });
        //No language
        if($languagesName->count() == 0) {
            //we return null
            return null;
        }
        //return langauages as array or collection
        return ($asCollection)?$languagesName:$languagesName->all();
    }

    /**
     * Return languages codes only
     *
     * @param bool $asCollection
     * @return mixed
     */
    public function languagesCodes($asCollection = false)
    {
        //We do not have a response
        if($this->getResponse() == null || $this->collectResults()->get('languages') == null) {
            //We return null only
            return null;
        }
        //Get languages codes only
        $languagesCodes = collect($this->collectResults()->get('languages'))->transform(function($item) {
            return isset($item['language'])?$item['language']:null;
        })->reject(function($item) {
            return $item == null;
        });;
        //No language
        if($languagesCodes->count() == 0) {
            //we return null
            return null;
        }
        //return langauages as array or collection
        return ($asCollection)?$languagesCodes:$languagesCodes->all();
    }

    /**
     * Get the language with the highest level of
     * confidence
     *
     * @return array|null|\Illuminate\Support\Collection
     */
    public function bestGuess($asCollection = false)
    {
        //We do not have a response
        if($this->getResponse() == null || $this->collectResults()->get('languages') == null) {
            //We return null only
            return null;
        }
        //Get the language with the highest score
        $highestScore = collect($this->collectResults()->get('languages'))->reduce(function($results, $item) {
            //return item with highest score
            return ($item['confidence'] >= $results['confidence'])?$item:$results;
        }, ['confidence' => 0]);
        //Return array or collection
        return ($asCollection)?collect($highestScore):$highestScore;
    }
}