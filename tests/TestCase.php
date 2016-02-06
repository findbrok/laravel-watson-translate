<?php

use Orchestra\Testbench\TestCase as TestBenchTestCase;
use Mockery;
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
		//Create instance of mock responses
		$this->mockResponses = new MockResponses;
	}

	/**
	 * Test if the getter really returns the property
	 * and that property is set
	 */
	public function testSetterGetter()
	{
		$this->translator->from('en')->to('fr')->usingModel('default');
		$this->assertEquals($this->translator->from, 'en');
		$this->assertEquals($this->translator->to, 'fr');
		$this->assertEquals(config('watson-translate.models.default'), $this->translator->modelId);
	}

	/**
	 * Test that when a property does not exists getter
	 * returns null
	 */
	public function testPropertyInexistent_ReturnNull()
	{
		$this->assertEquals(null, $this->translator->foo);
	}

	/**
	 * Test text translate with getTranslation method returns string
	 */
	public function testTextTranslate_GetTranslation_ReturnString()
	{
		$translator = Mockery::mock('FindBrok\WatsonTranslate\Translator');
		$translator->shouldReceive('textTranslate')->andReturn(Mockery::self());
		$translator->shouldReceive('getTranslation')->andReturn('Lorem ipsum');
		$this->assertEquals('Lorem ipsum', $translator->textTranslate()->getTranslation());
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