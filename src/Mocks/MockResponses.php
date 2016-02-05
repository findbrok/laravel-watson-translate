<?php

namespace FindBrok\WatsonTranslate\Mocks;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Faker\Factory as Faker;

/**
 * Class MockResponses
 * @package FindBrok\WatsonTranslate\Tests\Mocks
 */
class MockResponses
{
    /**
     * Faker\Factory
     *
     * @var \Faker\Factory
     */
    protected $faker;

    /**
     * Create a new instance of MockResponses
     *
     * @return void
     */
    public function __construct()
    {
        //Create a new faker instance
        $this->faker = Faker::create();
    }

	/**
	 * Mock a response for text translate function
	 *
	 * @return GuzzleHttp\Psr7\Response
	 */
	public function pretendTextTranslate()
	{
        //New sentence
        $sentence = $this->faker->sentence(rand(6, 10));
		//Build a new successful response for text translate
		return new Response(202, [
			'Content-Type' => 'application/json'
		], collect([
			'translations'      => [
				['translation' => $sentence]
			],
			'word_count'        => count(explode(' ', $sentence)),
			'character_count'   => strlen($sentence),
		])->toJson());
	}

    /**
     * Mock a response for the bulk translate function
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public function pretendBulkTranslate()
    {
        //Build a new successful response for bulk translate
        return new Response(202, [
            'Content-Type' => 'application/json'
        ], collect([
            'translations'      => [
                ['translation' => $this->faker->sentence(rand(6, 10))],
                ['translation' => $this->faker->sentence(rand(6, 10))],
            ],
            'word_count'        => $this->faker->numberBetween(10, 100),
            'character_count'   => $this->faker->numberBetween(10, 100),
        ])->toJson());
    }

    /**
     * Mock a response list languages
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public function pretendListLanguages()
    {
        //Build a new successful response for list languages
        return new Response(202, [
            'Content-Type' => 'application/json'
        ], collect([
            'languages' => [
                ['language' => 'af', 'name' => 'Afrikaans'],
                ['language' => 'ar', 'name' => 'Arabic'],
                ['language' => 'az', 'name' => 'Azerbaijani'],
                ['language' => 'en', 'name' => 'English'],
                ['language' => 'fr', 'name' => 'French'],
            ]
        ])->toJson());
    }

    /**
     * Mock a response for identify language
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public function pretendIdentifyLanguage()
    {
        //Build a new successful response for identify languages
        return new Response(202, [
            'Content-Type' => 'application/json'
        ], collect([
            'languages' => [
                ['language' => 'af', 'confidence' => $this->faker->randomFloat(null, 0.0001, 0.9999)],
                ['language' => 'ar', 'confidence' => $this->faker->randomFloat(null, 0.0001, 0.9999)],
                ['language' => 'az', 'confidence' => $this->faker->randomFloat(null, 0.0001, 0.9999)],
                ['language' => 'en', 'confidence' => $this->faker->randomFloat(null, 0.0001, 0.9999)],
                ['language' => 'fr', 'confidence' => $this->faker->randomFloat(null, 0.0001, 0.9999)],
            ]
        ])->toJson());
    }

    /**
     * Mock a response for model details
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public function pretendListModels()
    {
        //Build a new successful response for models list
        return new Response(202, [
            'Content-Type' => 'application/json'
        ], collect([
            'models' => [
                [
                    "model_id" => "ar-en",
                    "source" => "ar",
                    "target" => "en",
                    "base_model_id" => "",
                    "domain" => "news",
                    "customizable" => true,
                    "default_model" => true,
                    "owner" => "",
                    "status" => "available",
                    "name" => "",
                    "train_log" => null,
                ],
                [
                    "model_id" => "ar-en-conversational",
                    "source" => "ar",
                    "target" => "en",
                    "base_model_id" => "",
                    "domain" => "conversational",
                    "customizable" => false,
                    "default_model" => false,
                    "owner" => "",
                    "status" => "available",
                    "name" => "",
                    "train_log" => null
                ],
                [
                    "model_id" => "arz-en",
                    "source" => "arz",
                    "target" => "en",
                    "base_model_id" => "",
                    "domain" => "news",
                    "customizable" => true,
                    "default_model" => true,
                    "owner" => "",
                    "status" => "available",
                    "name" => "",
                    "train_log" => null
                ],
            ]
        ])->toJson());
    }

    /**
     * Get Model details
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public function pretendGetModelDetails()
    {
        //Build a new successful response for list languages
        return new Response(202, [
            'Content-Type' => 'application/json'
        ], collect([
            "model_id" => "en-fr",
            "source" => "en",
            "target" => "fr",
            "base_model_id" => "",
            "domain" => "news",
            "customizable" => true,
            "default_model" => true,
            "owner" => "",
            "status" => "available",
            "name" => "",
            "train_log" => null,
        ])->toJson());
    }
}