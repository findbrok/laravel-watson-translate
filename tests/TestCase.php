<?php

use Orchestra\Testbench\TestCase as TestBenchTestCase;
use FindBrok\WatsonTranslate\Tests\Mocks\MockResponses;

/**
 * Class TestCase
 */
class TestCase extends TestBenchTestCase
{
    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        //Create translator class
        $this->translator = app()->make('FindBrok\WatsonTranslate\Contracts\TranslatorInterface');
        //Create mock responses
        $this->mockResponses = new MockResponses;
        //Translator Class namespace
        $this->translatorClass = 'FindBrok\WatsonTranslate\Translator';
        //Create the mock client
        $this->client = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return ['FindBrok\WatsonTranslate\WatsonTranslateServiceProvider'];
    }

    /**
     * Set response as a result of textTranslate
     */
    public function fakeResponseForTextTranslate()
    {
        $this->client->method('send')->willReturn($this->mockResponses->pretendTextTranslateResponse());
    }

    /**
     * Set response as a result of bulkTranslate
     */
    public function fakeResponseForBulkTranslate()
    {
        $this->client->method('send')->willReturn($this->mockResponses->pretendBulkTranslateResponse());
    }

    /**
     * Test if the getter really returns the property
     * and that property is set
     */
    public function testSetterGetter()
    {
        $this->translator->from('en')->to('fr')->usingModel('default');
        $this->assertEquals('en', $this->translator->from);
        $this->assertEquals('fr', $this->translator->to);
        $this->assertEquals(config('watson-translate.models.default'), $this->translator->modelId);
    }

    /**
     * Test that when a property does not exists getter
     * returns null
     */
    public function testPropertyInexistent_ReturnNull()
    {
        $this->assertNull($this->translator->foo);
    }

    /**
     * Test textTranslate with getTranslation method returns string
     */
    public function testTextTranslate_WithGetTranslation_ReturnString()
    {
        $this->fakeResponseForTextTranslate();

        $translator = $this->getMock($this->translatorClass, ['getClient']);
        $translator->method('getClient')->willReturn($this->client);

        $this->assertEquals(
            'Lorem ipsum',
            $translator->textTranslate('Lorem ipsum')->getTranslation()
        );
    }

    /**
     * Test  the textTranslate with rawResults method returns json
     */
    public function testTextTranslate_WithRawResults_ReturnJson()
    {
        $this->fakeResponseForTextTranslate();

        $translator = $this->getMock($this->translatorClass, ['getClient']);
        $translator->method('getClient')->willReturn($this->client);

        $this->assertJsonStringEqualsJsonString(
            $this->mockResponses->pretendTextTranslateRaw(),
            $translator->textTranslate('Lorem ipsum')->rawResults()
        );
    }

    /**
     * Test the textTranslate with arrayResults method returns array
     */
    public function testTextTranslate_WithArrayResults_ReturnArray()
    {
        $this->fakeResponseForTextTranslate();

        $translator = $this->getMock($this->translatorClass, ['getClient']);
        $translator->method('getClient')->willReturn($this->client);

        $this->assertEquals(
            json_decode($this->mockResponses->pretendTextTranslateRaw(), true),
            $translator->textTranslate('Lorem ipsum')->arrayResults()
        );
    }

    /**
     * Test textTranslate with collectResults method returns collection
     */
    public function testTextTranslate_WithCollectionResults_ReturnCollection()
    {
        $this->fakeResponseForTextTranslate();

        $translator = $this->getMock($this->translatorClass, ['getClient']);
        $translator->method('getClient')->willReturn($this->client);

        $this->assertEquals(
            collect(json_decode($this->mockResponses->pretendTextTranslateRaw(), true)),
            $translator->textTranslate('Lorem ipsum')->collectResults()
        );
    }

    /**
     * Test textTranslate throws \GuzzleHttp\Exception\ClientException with getTranslation returns null
     *
     * @expectedException
     */
    public function testTextTranslate_WithGetTranslation_ThrowsClientException_ReturnsNull()
    {
        $translator = $this->getMock($this->translatorClass, ['send']);
        $translator->method('send')->willThrowException(
            Mockery::mock('GuzzleHttp\Exception\ClientException')
                ->shouldReceive(['getMessage', 'getCode'])
                ->andReturn(['Bad request', 400])
                ->getMock()
        );
        $this->assertNull($translator->textTranslate('lorem ipsum')->getTranslation());
    }

    /**
     * Test the bulkTranslate method with getTranslation method returns string
     */
    public function testBulkTranslate_WithGetTranslation_ReturnArray()
    {
        $this->fakeResponseForBulkTranslate();

        $translator = $this->getMock($this->translatorClass, ['getClient']);
        $translator->method('getClient')->willReturn($this->client);

        $this->assertEquals(
            ['Lorem ipsum', 'Lorem nam dolor'],
            $translator->bulkTranslate(['lorem', 'nam'])->getTranslation()
        );
    }

    /**
     * Test the bulkTranslate method with rawResults method returns json
     */
    public function testBulkTranslate_WithRawResults_ReturnJson()
    {
        $this->fakeResponseForBulkTranslate();

        $translator = $this->getMock($this->translatorClass, ['getClient']);
        $translator->method('getClient')->willReturn($this->client);

        $this->assertJsonStringEqualsJsonString(
            $this->mockResponses->pretendBulkTranslateRaw(),
            $translator->bulkTranslate(['lorem', 'nam'])->rawResults()
        );
    }

    /**
     * Test the bulkTranslate method with arrayResults method returns array
     */
    public function testBulkTranslate_WithArrayResults_ReturnArray()
    {
        $this->fakeResponseForBulkTranslate();

        $translator = $this->getMock($this->translatorClass, ['getClient']);
        $translator->method('getClient')->willReturn($this->client);

        $this->assertEquals(
            json_decode($this->mockResponses->pretendBulkTranslateRaw(), true),
            $translator->bulkTranslate(['lorem', 'nam'])->arrayResults()
        );
    }

    /**
     * Test the bulkTranslate method with collectResults method returns collection
     */
    public function testBulkTranslate_WithCollectionResults_ReturnCollection()
    {
        $this->fakeResponseForBulkTranslate();

        $translator = $this->getMock($this->translatorClass, ['getClient']);
        $translator->method('getClient')->willReturn($this->client);

        $this->assertEquals(
            collect(json_decode($this->mockResponses->pretendBulkTranslateRaw(), true)),
            $translator->bulkTranslate(['lorem', 'nam'])->collectResults()
        );
    }

    /**
     * Test the bulkTranslate method throws \GuzzleHttp\Exception\ClientException with getTranslation method returns null
     *
     * @expectedException
     */
    public function testBulkTranslate_WithGetTranslation_ThrowsClientException_ReturnsNull()
    {
        $translator = $this->getMock($this->translatorClass, ['send']);
        $translator->method('send')->willThrowException(
            Mockery::mock('GuzzleHttp\Exception\ClientException')
                ->shouldReceive(['getMessage', 'getCode'])
                ->andReturn(['Bad request', 400])
                ->getMock()
        );
        $this->assertNull($translator->bulkTranslate(['lorem', 'nam'])->getTranslation());
    }
}
