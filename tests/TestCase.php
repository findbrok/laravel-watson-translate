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
	 * Test text translate with getTranslation method returns string
	 */
	public function testTextTranslate_GetTranslation_ReturnString()
	{
		$translator = $this->getMock('FindBrok\WatsonTranslate\Translator', ['request', 'send', 'getResponse', 'rawResults']);
		$translator->method('request')->willReturnSelf();
		$translator->method('send')->willReturnSelf();
		$translator->method('getResponse')->willReturn($this->mockResponses->pretendTextTranslateResponse());
		$translator->method('rawResults')->willReturn($this->mockResponses->pretendTextTranslateRaw());
		$this->assertEquals('Lorem ipsum', $translator->textTranslate('Lorem ipsum')->getTranslation());
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
}