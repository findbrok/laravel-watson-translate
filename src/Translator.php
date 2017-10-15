<?php

namespace FindBrok\WatsonTranslate;

use FindBrok\WatsonBridge\Exceptions\WatsonBridgeException;
use FindBrok\WatsonTranslate\Contracts\TranslatorInterface;

/**
 * Class Translator.
 */
class Translator extends AbstractTranslator implements TranslatorInterface
{
    /**
     * Translates the input text from the source language to the target language.
     *
     * @param string $text
     * @throws WatsonBridgeException
     * @return self
     */
    public function textTranslate($text)
    {
        //Send request to Watson
        $this->results = $this->makeBridge()->get('v2/translate', collect([
            'model_id'  => $this->getModelId(),
            'source'    => $this->from,
            'target'    => $this->to,
            'text'      => $text,
        ])->reject(function ($item) {
            return is_null($item) || empty($item);
        })->all())->getBody()->getContents();
        //Return translator object
        return $this;
    }

    /**
     * Translate a large text from the source language to the target language.
     * Also used to translate multiple paragraphs or multiple inputs.
     *
     * @param string|array $text
     * @throws WatsonBridgeException
     * @return self
     */
    public function bulkTranslate($text)
    {
        //Send request to Watson
        $this->results = $this->makeBridge()->post('v2/translate', collect([
            'model_id'  => $this->getModelId(),
            'source'    => $this->from,
            'target'    => $this->to,
            'text'      => $text,
        ])->reject(function ($item) {
            return is_null($item) || empty($item);
        })->all())->getBody()->getContents();
        //Return translator object
        return $this;
    }

    /**
     * List all languages that can be identified by watson.
     *
     * @throws WatsonBridgeException
     * @return self
     */
    public function listLanguages()
    {
        //Send request to Watson
        $this->results = $this->makeBridge()
                              ->get('v2/identifiable_languages')
                              ->getBody()
                              ->getContents();
        //Return translator object
        return $this;
    }

    /**
     * Identify the language in which the text is written
     * with a certain level of confidence.
     *
     * @param string $text
     * @throws WatsonBridgeException
     * @return self
     */
    public function identifyLanguage($text)
    {
        //Send request to Watson
        $this->results = $this->makeBridge()
                              ->post('v2/identify', ['text' => $text], 'query')
                              ->getBody()
                              ->getContents();
        //Return translator object
        return $this;
    }

    /**
     * Lists available standard and custom models by source or target language.
     *
     * @param bool $defaultOnly
     * @param string $sourceFilter
     * @param string $targetFilter
     * @throws WatsonBridgeException
     * @return self
     */
    public function listModels($defaultOnly = null, $sourceFilter = null, $targetFilter = null)
    {
        //Send request to Watson
        $this->results = $this->makeBridge()
                              ->get('v2/models', collect([
                                  'source'    => $sourceFilter,
                                  'target'    => $targetFilter,
                                  'default'   => $defaultOnly,
                              ])->reject(function ($item) {
                                  return is_null($item) || empty($item);
                              })->all())->getBody()->getContents();
        //Return translator object
        return $this;
    }

    /**
     * Returns information, including training status, about a specified translation model.
     *
     * @throws WatsonBridgeException
     * @return self
     */
    public function getModelDetails()
    {
        //Send request to Watson
        $this->results = $this->makeBridge()
                              ->get('v2/models/' . $this->getModelId())
                              ->getBody()
                              ->getContents();
        //Return translator object
        return $this;
    }

    /**
     * Creates a new translation model.
     *
     * @param string $baseModelId
     * @param string $modelName
     * @return self
     */
    public function createModel($baseModelId = null, $modelName = null)
    {
        //Send request to Watson
        $this->results = $this->makeBridge()
                              ->post('v2/models', collect([
                                  [
                                    'name'    => 'base_model_id',
                                    'contents'    => $baseModelId,
                                  ],
                                  [
                                    'name'    => 'name',
                                    'contents'    => $modelName,
                                  ],
                              ])->reject(function ($item) {
                                  return is_null($item) || empty($item);
                              })->all(), 'multipart')->getBody()->getContents();
        //Return translator object
        return $this;
    }

    /**
     * Delete a translation model.
     *
     * @param string $modelId
     * @throws WatsonBridgeException
     * @return self
     */
    public function deleteModel($modelId = null)
    {
        //Send request to Watson
        $this->results = $this->makeBridge()
          ->delete('v2/models/' . $modelId, null)
          ->getBody()->getContents();
        //Return translator object
        return $this;
    }
}
