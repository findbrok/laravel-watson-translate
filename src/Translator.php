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
			//Perform get request
			$response = $this->request('GET', 'v2/translate')->send([
				'query' => collect([
					'model_id'  => $this->modelId,
					'source'    => $this->from,
					'target'    => $this->to,
					'text'      => $text,
				])->reject(function($item) {
					return $item == null || $item == '';
				})->all()
			]);
			//return result collection
			return collect(json_decode($response->getBody()->getContents(), true));
		} catch (ClientException $e) {
			//Unexpected error
			return null;
		}
	}
}