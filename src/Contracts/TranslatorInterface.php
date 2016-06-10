<?php

namespace FindBrok\WatsonTranslate\Contracts;

/**
 * Interface TranslatorInterface.
 */
interface TranslatorInterface
{
    /**
     * Translates the input text from the source language to the target language.
     *
     * @param string $text
     * @throws WatsonBridgeException
     * @return self
     */
    public function textTranslate($text);

    /**
     * Translate a large text from the source language to the target language.
     * Also used to translate multiple paragraphs or multiple inputs.
     *
     * @param string|array $text
     * @throws WatsonBridgeException
     * @return self
     */
    public function bulkTranslate($text);

    /**
     * List all languages that can be identified by watson.
     *
     * @throws WatsonBridgeException
     * @return self
     */
    public function listLanguages();

    /**
     * Identify the language in which the text is written
     * with a certain level of confidence.
     *
     * @param string $text
     * @throws WatsonBridgeException
     * @return self
     */
    public function identifyLanguage($text);

    /**
     * Lists available standard and custom models by source or target language.
     *
     * @param bool $defaultOnly
     * @param string $sourceFilter
     * @param string $targetFilter
     * @throws WatsonBridgeException
     * @return self
     */
    public function listModels($defaultOnly = null, $sourceFilter = null, $targetFilter = null);

    /**
     * Returns information, including training status, about a specified translation model.
     *
     * @throws WatsonBridgeException
     * @return self
     */
    public function getModelDetails();

    /**
     * Creates a new translation model.
     *
     * @param string $baseModelId
     * @param string $modelName
     * @return mixed
     */
    public function createModel($baseModelId = null, $modelName = null);

    /**
     * Delete a translation model.
     *
     * @param string $modelId
     * @return mixed
     */
    public function deleteModel($modelId = null);
}
