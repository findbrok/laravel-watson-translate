<?php

use FindBrok\WatsonTranslate\Tests\Mocks\MockResponses;
use Orchestra\Testbench\TestCase as TestBenchTestCase;

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
        //Create mock responses
        $this->mockResponses = new MockResponses;
        //Translator Class namespace
        $this->translatorClass = 'FindBrok\WatsonTranslate\Translator';
        //Make translator
        $this->translator = app()->make($this->translatorClass);
        //Mock Watson Bridge
        $this->bridge = $this->getMockBuilder('FindBrok\WatsonBridge\Bridge')
                             ->disableOriginalConstructor()
                             ->setMethods(['post', 'get'])
                             ->getMock();
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
        //Set return value of post method
        $this->bridge->method('get')
            ->withAnyParameters()
            ->willReturn($this->mockResponses->pretendTextTranslateResponse());
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        //Fake Watson Bridge
        $this->assertEquals(
            'Lorem ipsum',
            $this->translator->textTranslate('Lorem ipsum')->getTranslation()
        );
    }

    /**
     * Test  the textTranslate with rawResults method returns json
     */
    public function testTextTranslate_WithRawResults_ReturnJson()
    {
        //Set return value of post method
        $this->bridge->method('get')
            ->withAnyParameters()
            ->willReturn($this->mockResponses->pretendTextTranslateResponse());
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        $this->assertJsonStringEqualsJsonString(
            $this->mockResponses->pretendTextTranslateRaw(),
            $this->translator->textTranslate('Lorem ipsum')->getResults()
        );
    }

    /**
     * Test the textTranslate with arrayResults method returns array
     */
    public function testTextTranslate_WithArrayResults_ReturnArray()
    {
        //Set return value of post method
        $this->bridge->method('get')
            ->withAnyParameters()
            ->willReturn($this->mockResponses->pretendTextTranslateResponse());
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        $this->assertEquals(
            json_decode($this->mockResponses->pretendTextTranslateRaw(), true),
            $this->translator->textTranslate('Lorem ipsum')->arrayResults()
        );
    }

    /**
     * Test textTranslate with collectResults method returns collection
     */
    public function testTextTranslate_WithCollectionResults_ReturnCollection()
    {
        //Set return value of post method
        $this->bridge->method('get')
            ->withAnyParameters()
            ->willReturn($this->mockResponses->pretendTextTranslateResponse());
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        $this->assertEquals(
            collect(json_decode($this->mockResponses->pretendTextTranslateRaw(), true)),
            $this->translator->textTranslate('Lorem ipsum')->collectResults()
        );
    }

    /**
     * Test textTranslate throws WatsonBridgeException
     *
     * @expectedException \FindBrok\WatsonBridge\Exceptions\WatsonBridgeException
     */
    public function testTextTranslate_WithGetTranslation_ThrowsClientException_ReturnsNull()
    {
        //Set return value of post method
        $this->bridge->method('get')
            ->withAnyParameters()
            ->will($this->throwException(new \FindBrok\WatsonBridge\Exceptions\WatsonBridgeException('Foo', 400)));
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        $this->translator->textTranslate('lorem ipsum')->getTranslation();
    }

    /**
     * Test the bulkTranslate method with getTranslation method returns string
     */
    public function testBulkTranslate_WithGetTranslation_ReturnArray()
    {
        //Set return value of post method
        $this->bridge->method('post')
            ->withAnyParameters()
            ->willReturn($this->mockResponses->pretendBulkTranslateResponse());
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        $this->assertEquals(
            ['Lorem ipsum', 'Lorem nam dolor'],
            $this->translator->bulkTranslate(['lorem', 'nam'])->getTranslation()
        );
    }

    /**
     * Test the bulkTranslate method with rawResults method returns json
     */
    public function testBulkTranslate_WithRawResults_ReturnJson()
    {
        //Set return value of post method
        $this->bridge->method('post')
            ->withAnyParameters()
            ->willReturn($this->mockResponses->pretendBulkTranslateResponse());
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        $this->assertJsonStringEqualsJsonString(
            $this->mockResponses->pretendBulkTranslateRaw(),
            $this->translator->bulkTranslate(['lorem', 'nam'])->getResults()
        );
    }

    /**
     * Test the bulkTranslate method with arrayResults method returns array
     */
    public function testBulkTranslate_WithArrayResults_ReturnArray()
    {
        //Set return value of post method
        $this->bridge->method('post')
            ->withAnyParameters()
            ->willReturn($this->mockResponses->pretendBulkTranslateResponse());
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        $this->assertEquals(
            json_decode($this->mockResponses->pretendBulkTranslateRaw(), true),
            $this->translator->bulkTranslate(['lorem', 'nam'])->arrayResults()
        );
    }

    /**
     * Test the bulkTranslate method with collectResults method returns collection
     */
    public function testBulkTranslate_WithCollectionResults_ReturnCollection()
    {
        //Set return value of post method
        $this->bridge->method('post')
            ->withAnyParameters()
            ->willReturn($this->mockResponses->pretendBulkTranslateResponse());
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        $this->assertEquals(
            collect(json_decode($this->mockResponses->pretendBulkTranslateRaw(), true)),
            $this->translator->bulkTranslate(['lorem', 'nam'])->collectResults()
        );
    }

    /**
     * Test the bulkTranslate method throws WatsonBridgeException
     *
     * @expectedException \FindBrok\WatsonBridge\Exceptions\WatsonBridgeException
     */
    public function testBulkTranslate_WithGetTranslation_ThrowsClientException_ReturnsNull()
    {
        //Set return value of post method
        $this->bridge->method('post')
            ->withAnyParameters()
            ->will($this->throwException(new \FindBrok\WatsonBridge\Exceptions\WatsonBridgeException('Foo', 400)));
        //Override Bridge in IOC
        $this->app->instance('WatsonTranslateBridge', $this->bridge);

        $this->translator->bulkTranslate(['lorem', 'nam'])->getTranslation();
    }
}
