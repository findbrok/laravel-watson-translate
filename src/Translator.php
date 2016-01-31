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
}