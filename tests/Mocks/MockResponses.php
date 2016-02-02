<?php

namespace FindBrok\WatsonTranslate\Tests\Mocks;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

/**
 * Class MockResponses
 * @package FindBrok\WatsonTranslate\Tests\Mocks
 */
class MockResponses
{
	/**
	 * Mock a response for text translate function
	 *
	 * @return
	 */
	public function textTranslateSuccess()
	{
		//Build a new successful response for text translate
		return new Response(202, [
			'Content-Type' => 'application/json'
		], collect([
			'translations'      => [
				['translation' => 'Lorem ipsum dolor sit amet, cum audire deleniti appellantur te.']
			],
			'word_count'        => 22,
			'character_count'   => 124,
		])->toJson());
	}
}