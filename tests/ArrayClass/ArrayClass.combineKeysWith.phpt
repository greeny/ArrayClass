<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class CombineKeysWithTestCase extends TestCase
{

	public function dataProvider()
	{
		$values = ['a', 'b', 'c'];

		$arrays = [
			['a', 'b', 'c'],
			[1, 2, 3],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_combine($array, $values),
				$values,
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testCombineKeysWith($array, $array1, $values)
	{
		Assert::same($array1, ArrayClass::from($array)->combineKeysWith($values)->toArray());
		Assert::same($array1, ArrayClass::from($array)->combineKeysWith(ArrayClass::from($values))->toArray());
	}

}

testCase(new CombineKeysWithTestCase);
