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
}