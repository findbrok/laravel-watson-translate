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
}