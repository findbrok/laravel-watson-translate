<?php


namespace FindBrok\WatsonTranslate\Contracts;

/**
 * Interface TranslatorInterface
 * @package FindBrok\WatsonTranslate\Contracts
 */
interface TranslatorInterface
{
    /**
     * Translates the input text from the source language to the target language
     *
     * @param string $text
     * @return \Illuminate\Support\Collection|null
     */
    public function textTranslate($text = '');

    /**
     * Translate a large text from the source language to the target language.
     * Also used to translate multiple paragraphs or multiple inputs
     *
     * @param string|array $text
     * @return \Illuminate\Support\Collection|null
     */
    public function bulkTranslate($text = null);

    /**
     * List all languages that can be identified by watson
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function listLanguages();

    /**
     * Identify the language in which the text is written
     * with a certain level of confidence
     *
     * @param string $text
     * @return \Illuminate\Support\Collection|null
     */
    public function identifyLanguage($text = '');

    /**
     * Lists available standard and custom models by source or target language.
     *
     * @param bool $defaultOnly
     * @param string $sourceFilter
     * @param string $targetFilter
     * @return \Illuminate\Support\Collection|null
     */
    public function listModels($defaultOnly = null, $sourceFilter = null, $targetFilter = null);

    /**
     * Returns information, including training status, about a specified translation model.
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getModelDetails();

    /**
     * Creates a new translation model
     *
     * @param string $baseModelId
     * @param string $modelName
     * @return mixed
     */
    public function createModel($baseModelId = null, $modelName = null);

    /**
     * Delete a translation model
     *
     * @param string $modelId
     * @return mixed
     */
    public function deleteModel($modelId = null);
}
