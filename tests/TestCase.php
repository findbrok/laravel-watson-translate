<?php

use Orchestra\Testbench\TestCase as TestBenchTestCase;
use FindBrok\WatsonTranslate\Mocks\MockResponses;

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
		$client = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
		$client->method('send')->willReturn($this->mockResponses->pretendTextTranslateResponse());

		$translator = $this->getMock($this->translatorClass, ['getClient']);
		$translator->method('getClient')->willReturn($client);

		$this->assertEquals('Lorem ipsum', $translator->textTranslate('Lorem ipsum')->getTranslation());
	}

	/**
	 * Test  the textTranslate with rawResults method returns json
	 */
	public function testTextTranslate_WithRawResults_ReturnJson()
	{
		$client = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
		$client->method('send')->willReturn($this->mockResponses->pretendTextTranslateResponse());

		$translator = $this->getMock($this->translatorClass, ['getClient']);
		$translator->method('getClient')->willReturn($client);

		$this->assertJsonStringEqualsJsonString(
			$this->mockResponses->pretendTextTranslateRaw(),
			$translator->textTranslate('Lorem ipsum')->rawResults()
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
		$client = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
		$client->method('send')->willReturn($this->mockResponses->pretendBulkTranslateResponse());

		$translator = $this->getMock($this->translatorClass, ['getClient']);
		$translator->method('getClient')->willReturn($client);

		$this->assertSame(['Lorem ipsum', 'Lorem nam dolor'], $translator->bulkTranslate(['lorem', 'nam'])->getTranslation());
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