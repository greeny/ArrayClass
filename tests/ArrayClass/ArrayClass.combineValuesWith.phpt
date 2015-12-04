<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class CombineValuesWithTestCase extends TestCase
{

	public function dataProvider()
	{
		$keys = ['a', 'b', 'c'];

		$arrays = [
			['a', 'b', 'c'],
			[1, 2, 3],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_combine($keys, $array),
				$keys,
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testCombineValuesWith($array, $array1, $keys)
	{
		Assert::same($array1, ArrayClass::from($array)->combineValuesWith($keys)->toArray());
		Assert::same($array1, ArrayClass::from($array)->combineValuesWith(ArrayClass::from($keys))->toArray());
	}

}

testCase(new CombineValuesWithTestCase);
