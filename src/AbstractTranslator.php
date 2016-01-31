<?php

namespace FindBrok\WatsonTranslate;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class AbstractTranslator
 * @package FindBrok\WatsonTranslate
 */
abstract class AbstractTranslator
{
	/**
	 * Api end point of the translation service
	 *
	 * @var string
	 */
	protected $endPoint;

	/**
	 * Guzzle http client for performing API request
	 *
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

	/**
	 * The request object
	 *
	 * @var \GuzzleHttp\Psr7\Request
	 */
	protected $request;

	/**
	 * The language from which we are translating
	 *
	 * @var string
	 */
	protected $from = null;

	/**
	 * The language to which we want to get results
	 *
	 * @var string
	 */
	protected $to = null;

	/**
	 * The model Id we want to use for translation
	 *
	 * @var string
	 */
	protected $modelId = null;

	/**
	 * Create a new instance of the AbstractTranslator
	 */
	public function __construct()
	{
		//Set the client
		$this->setClient();
	}

	/**
	 * Creates the http client
	 *
	 * @return void
	 */
	private function setClient()
	{
		//Set the Api end point
		$this->endPoint = config('watson-translate.api_endpoint');
		//Create client using API endpoint sets it the th class variable
		$this->client = new Client([
			'base_uri'  => $this->endPoint,
		]);
	}

	/**
	 * Return the Http client instance
	 *
	 * @return \GuzzleHttp\Client
	 */
	public function getClient()
	{
		//Return client
		return $this->client;
	}

	/**
	 * Return the authorization for making request
	 *
	 * @return array
	 */
	private function getAuth()
	{
		//Return access authorization
		return [
			'auth' => [config('watson-translate.service_credentials.username'), config('watson-translate.service_credentials.password')]
		];
	}

	/**
	 * Return the headers used for making request
	 *
	 * @return array
	 */
	private function getHeaders()
	{
		//Return headers
		return [
			'headers' => [
				'Accept' => 'application/json'
			]
		];
	}

	/**
	 * Set the language code of the language
	 * we are translating from
	 *
	 * @param string $lang
	 * @return self
	 */
	public function from($lang = '')
	{
		//Set the language from code
		$this->from = $lang;
		//return the translator
		return $this;
	}

	/**
	 * Set the language code of the language
	 * we are translating to
	 *
	 * @param string $lang
	 * @return self
	 */
	public function to($lang = '')
	{
		//Set the language to code
		$this->to = $lang;
		//return the translator
		return $this;
	}

	/**
	 * Set the model id of the model we want to use
	 * for translation, overrides to and from
	 *
	 * @param string $modelName
	 * @return self
	 */
	public function usingModel($modelName = '')
	{
		//Set the model id
		$this->modelId = config('watson-translate.models.'.$modelName);
		//return the translator
		return $this;
	}

	/**
	 * Build a request
	 *
	 * @param string $method
	 * @param string $uri
	 * @param array $options
	 * @return self
	 */
	protected function request($method = 'GET', $uri = null, $options = [])
	{
		//Build the request
		$this->request = new Request($method, $uri, $options);
		//Return the request
		return $this;
	}

	/**
	 * Send API request to Watson service
	 *
	 * @param array $options
	 * @return \GuzzleHttp\Psr7\Response
	 */
	protected function send($options = [])
	{
		//Send request with client and return response
		return $this->client->send($this->request, collect($this->getAuth())->merge($this->getHeaders())->merge($options)->all());
	}
}