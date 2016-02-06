<?php

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
		//Create translator class
		$this->translator = app()->make('FindBrok\WatsonTranslate\Contracts\TranslatorInterface');
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
		$this->assertEquals($this->translator->modelId, config('watson-translate.models.default'));
	}

	/**
	 * Test that when a property does not exists getter
	 * returns null
	 */
	public function testPropertyInexistent_ReturnNull()
	{
		$this->assertEquals($this->translator->foo, null);
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