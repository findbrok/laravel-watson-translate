<?php

namespace FindBrok\WatsonTranslate;

use FindBrok\WatsonTranslate\Contracts\TranslatorInterface;
use Exception;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Translator
 * @package FindBrok\WatsonTranslate
 */
class Translator extends AbstractTranslator implements TranslatorInterface
{

	/**
	 * Translates the input text from the source language to the target language
	 *
	 * @param string $text
	 * @return self
	 */
	public function textTranslate($text = '')
	{
		//No text input
		if($text == '') {
			//We return
			return $this;
		}
		try {
			//Perform get request on client and return results
            $this->request('GET', 'v2/translate')->send([
				'query' => collect([
					'model_id'  => $this->modelId,
					'source'    => $this->from,
					'target'    => $this->to,
					'text'      => $text,
				])->reject(function($item) {
					return $item == null || $item == '';
				})->all()
			]);
		} catch (ClientException $e) {
			//Set response to null
			$this->response = null;
			//Set error message
			$this->error = $e->getMessage();
		}
		//Return translator object
		return $this;
	}

	/**
	 * Translate a large text from the source language to the target language.
	 * Also used to translate multiple paragraphs or multiple inputs
	 *
	 * @param string|array $text
	 * @return self
	 */
	public function bulkTranslate($text = null)
	{
		//No text input
		if($text == null) {
			//We return
			return $this;
		}
		try {
			//Perform a Post request on client and return results
			$this->request('POST', 'v2/translate')->send([
				'json' => collect([
					'model_id'  => $this->modelId,
					'source'    => $this->from,
					'target'    => $this->to,
					'text'      => $text
				])->reject(function($item) {
					return $item == null || $item == '';
				})->all()
			]);
		} catch (ClientException $e) {
			//Set response to null
			$this->response = null;
			//Set error message
			$this->error = $e->getMessage();
		}
		//Return translator object
		return $this;
	}

	/**
	 * List all languages that can be identified by watson
	 *
	 * @return self|null
	 */
	public function listLanguages()
	{
		try {
			//Perform a Get request on client and return results
			$this->request('GET', 'v2/identifiable_languages')->send();
		} catch (ClientException $e) {
			//Set response to null
			$this->response = null;
			//Set error message
			$this->error = $e->getMessage();
		}
		//Return translator object
		return $this;
	}

	/**
	 * Identify the language in which the text is written
	 * with a certain level of confidence
	 *
	 * @param string $text
	 * @return self
	 */
	public function identifyLanguage($text = '')
	{
		try {
			//Perform a post request to identify the language
            $this->request('POST', 'v2/identify')->send([
				'query' => collect([
					'text' => $text
				])->all()
			]);
		} catch (ClientException $e) {
			//Set response to null
			$this->response = null;
			//Set error message
			$this->error = $e->getMessage();
		}
		//Return translator object
		return $this;
	}

	/**
	 * Lists available standard and custom models by source or target language.
	 *
	 * @param bool $defaultOnly
	 * @param string $sourceFilter
	 * @param string $targetFilter
	 * @return self|null
	 */
	public function listModels($defaultOnly = null, $sourceFilter = null, $targetFilter = null)
	{
		try {
			//Perform a get request to list all models and return it
			$this->request('GET', 'v2/models')->send([
				'query' => collect([
					'source'    => $sourceFilter,
					'target'    => $targetFilter,
					'default'   => $defaultOnly,
				])->reject(function($item) {
					return $item == null || $item == '';
				})->all()
			]);
		} catch (ClientException $e) {
			//Set response to null
			$this->response = null;
			//Set error message
			$this->error = $e->getMessage();
		}
		//Return translator object
		return $this;
	}

	/**
	 * Returns information, including training status, about a specified translation model.
	 *
	 * @return self|null
	 */
	public function getModelDetails()
	{
		try {
			//Perform a get Request to get the model's Details and return it
            $this->request('GET', 'v2/models/'.$this->modelId)->send();
		} catch (ClientException $e) {
			//Set response to null
			$this->response = null;
			//Set error message
			$this->error = $e->getMessage();
		}
		//Return translator object
		return $this;
	}

	/**
	 * Creates a new translation model
	 *
	 * @param string $baseModelId
	 * @param string $modelName
	 * @return mixed
	 */
	public function createModel($baseModelId = null, $modelName = null)
	{
		//TODO:Implement creation of Translation model
	}

	/**
	 * Delete a translation model
	 *
	 * @param string $modelId
	 * @return mixed
	 */
	public function deleteModel($modelId = null)
	{
		//TODO:Implement deletion of translation model
	}
}