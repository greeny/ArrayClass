<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class PopTestCase extends TestCase
{

	public function dataProvider()
	{
		$arrays = [
			[1, 2, 3],
			['a', 'b', 'c'],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_pop($array),
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testPop($array, $value)
	{
		Assert::same($value, ArrayClass::from($array)->pop());
	}

}

testCase(new PopTestCase);
