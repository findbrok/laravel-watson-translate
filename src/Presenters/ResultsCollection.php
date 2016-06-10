<?php

namespace FindBrok\WatsonTranslate\Presenters;

/**
 * Class ResultsCollection.
 */
trait ResultsCollection
{
    /**
     * Checks and see if we have some translations in the results.
     *
     * @return bool
     */
    public function hasTranslations()
    {
        return count($this->collectResults()->get('translations')) > 0;
    }

    /**
     * Checks and see if we have multiple translations in the results.
     *
     * @return bool
     */
    public function hasMoreThanOneTranslation()
    {
        return count($this->collectResults()->get('translations')) > 1;
    }

    /**
     * Returns the results of the response array.
     *
     * @return array|null
     */
    public function arrayResults()
    {
        return json_decode($this->getResults(), true);
    }

    /**
     * Returns the results of the response as a collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collectResults()
    {
        return collect($this->arrayResults());
    }

    /**
     * Returns only the translations from results.
     *
     * @param bool $asCollection
     * @return mixed
     */
    public function getTranslation($asCollection = false)
    {
        //We have some translations
        if ($this->hasTranslations()) {
            //More than one
            if ($this->hasMoreThanOneTranslation()) {
                //Get only translations
                $translations = collect($this->collectResults()->get('translations'))->transform(function ($item) {
                    return $item['translation'];
                });
                //Return the translations as array or collection
                return $asCollection ? $translations : $translations->all();
            }
            //Return the single translation as collection or string
            return $asCollection ?
                collect($this->collectResults()->get('translations')) :
                collect(collect($this->collectResults()->get('translations'))->first())->get('translation');
        }
        //Nothing to return
    }

    /**
     * Return languages names only.
     *
     * @param bool $asCollection
     * @return array|\Illuminate\Support\Collection
     */
    public function languagesNames($asCollection = false)
    {
        //Get languages name only
        $languagesName = collect($this->collectResults()->get('languages'))->transform(function ($item) {
            return isset($item['name']) ? $item['name'] : null;
        })->reject(function ($item) {
            return is_null($item);
        });

        //No language
        if ($languagesName->count() == 0) {
            //we return null
            return;
        }

        //return languages as array or collection
        return $asCollection ? $languagesName : $languagesName->all();
    }

    /**
     * Return languages codes only.
     *
     * @param bool $asCollection
     * @return array|\Illuminate\Support\Collection
     */
    public function languagesCodes($asCollection = false)
    {
        //Get languages codes only
        $languagesCodes = collect($this->collectResults()->get('languages'))->transform(function ($item) {
            return isset($item['language']) ? $item['language'] : null;
        })->reject(function ($item) {
            return is_null($item);
        });

        //No language
        if ($languagesCodes->count() == 0) {
            //we return null
            return;
        }

        //return languages as array or collection
        return $asCollection ? $languagesCodes : $languagesCodes->all();
    }

    /**
     * Get the language with the highest level of
     * confidence.
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function bestGuess($asCollection = false)
    {
        //Get the language with the highest score
        $highestScore = collect($this->collectResults()->get('languages'))->reduce(function ($results, $item) {
            //return item with highest score
            return ($item['confidence'] >= $results['confidence']) ? $item : $results;
        }, ['confidence' => 0]);

        //Return array or collection
        return $asCollection ? collect($highestScore) : $highestScore;
    }
}
