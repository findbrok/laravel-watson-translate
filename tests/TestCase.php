<?php

/**
 * Class TestCase
 */
class TestCase extends PHPUnit_Framework_TestCase
{
	/**
	 * Testing text translate method
	 */
	public function testTextTranslate()
	{
		$stack = array();
		$this->assertEquals(0, count($stack));
	}
}