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
	 * @return \Illuminate\Support\Collection|null
	 */
	public function textTranslate($text = '')
	{
		try {
			//No text input
			if($text == '') {
				//We return null
				return null;
			}
			//Perform get request on client and return results
			return $this->request('GET', 'v2/translate')->send([
				'query' => collect([
					'model_id'  => $this->modelId,
					'source'    => $this->from,
					'target'    => $this->to,
					'text'      => $text,
				])->reject(function($item) {
					return $item == null || $item == '';
				})->all()
			])->collectResults();
		} catch (ClientException $e) {
			//Unexpected client error
			return null;
		}
	}

	/**
	 * Translate a large text from the source language to the target language.
	 * Also used to translate multiple paragraphs or multiple inputs
	 *
	 * @param string|array $text
	 * @return \Illuminate\Support\Collection|null
	 */
	public function bulkTranslate($text = null)
	{
		try {
			//No text input
			if($text == null) {
				//We return null
				return null;
			}
			//Perform a Post request on client and return results
			return $this->request('POST', 'v2/translate')->send([
				'json' => collect([
					'model_id'  => $this->modelId,
					'source'    => $this->from,
					'target'    => $this->to,
					'text'      => $text
				])->reject(function($item) {
					return $item == null || $item == '';
				})->all()
			])->collectResults();
		} catch (ClientException $e) {
			//Unexpected client error
			return null;
		}
	}

	/**
	 * List all languages that can be identified by watson
	 *
	 * @return \Illuminate\Support\Collection|null
	 */
	public function listLanguages()
	{
		try {
			//Perform a Get request on client and return results
			return $this->request('GET', 'v2/identifiable_languages')->send()->collectResults();
		} catch (ClientException $e) {
			//Unexpected client error
			return null;
		}
	}

	/**
	 * Identify the language in which the text is written
	 * with a certain level of confidence
	 *
	 * @param string $text
	 * @return \Illuminate\Support\Collection|null
	 */
	public function identifyLanguage($text = '')
	{
		try {
			//Perform a post request to identify the language
			return $this->request('POST', 'v2/identify')->send([
				'query' => collect([
					'text' => $text
				])->all()
			])->collectResults();
		} catch (ClientException $e) {
			//Unexpected client error
			return null;
		}
	}

	/**
	 * Lists available standard and custom models by source or target language.
	 *
	 * @param bool $defaultOnly
	 * @param string $sourceFilter
	 * @param string $targetFilter
	 * @return \Illuminate\Support\Collection|null
	 */
	public function listModels($defaultOnly = null, $sourceFilter = null, $targetFilter = null)
	{
		try {
			//Perform a get request to list all models and return it
			return $this->request('GET', 'v2/models')->send([
				'query' => collect([
					'source'    => $sourceFilter,
					'target'    => $targetFilter,
					'default'   => $defaultOnly,
				])->reject(function($item) {
					return $item == null || $item == '';
				})->all()
			])->collectResults();
		} catch (ClientException $e) {
			//Unexpected client error
			return null;
		}
	}

	/**
	 * Returns information, including training status, about a specified translation model.
	 *
	 * @return \Illuminate\Support\Collection|null
	 */
	public function getModelDetails()
	{
		try {
			//Perform a get Request to get the model's Details and return it
			return $this->request('GET', 'v2/models/'.$this->modelId)->send()->collectResults();
		} catch (ClientException $e) {
			//Unexpected client error
			return null;
		}
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