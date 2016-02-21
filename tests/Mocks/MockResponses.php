<?php

namespace FindBrok\WatsonTranslate\Tests\Mocks;

use GuzzleHttp\Psr7\Response;
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
    public function pretendTextTranslateResponse()
    {
        //New sentence
        $sentence = 'Lorem ipsum';
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
     * Mock a raw json results for text translate function
     *
     * @return string
     */
    public function pretendTextTranslateRaw()
    {
        return $this->pretendTextTranslateResponse()->getBody()->getContents();
    }

    /**
     * Mock a response for the bulk translate function
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public function pretendBulkTranslateResponse()
    {
        //Build a new successful response for bulk translate
        return new Response(202, [
            'Content-Type' => 'application/json'
        ], collect([
            'translations'      => [
                ['translation' => 'Lorem ipsum'],
                ['translation' => 'Lorem nam dolor'],
            ],
            'word_count'        => 100,
            'character_count'   => 200,
        ])->toJson());
    }

    /**
     * Mock a raw json results for Bulk translate
     *
     * @return string
     */
    public function pretendBulkTranslateRaw()
    {
        //Return content of pretended response
        return $this->pretendBulkTranslateResponse()->getBody()->getContents();
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
