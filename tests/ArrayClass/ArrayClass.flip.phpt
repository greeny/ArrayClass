<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class FlipTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[
				'a' => 'b',
				'b' => 'c',
				'c' => 'd',
				'd' => 'e',
				'e' => 'a',
			]
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_flip($array),
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testFlip($array, $array1)
	{
		Assert::same($array1, ArrayClass::from($array)->flip()->toArray());
	}

}

testCase(new FlipTestCase);
