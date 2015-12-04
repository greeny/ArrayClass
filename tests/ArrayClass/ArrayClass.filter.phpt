<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class FilterTestCase extends TestCase
{

	public function dataProvider()
	{
		$callback = function ($item) {
			return $item === 42; // because why not
		};

		$arrays = [
			[21, 42, 42, 84, '42']
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_filter($array, $callback),
				$callback
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testFilter($array, $array1, $callback)
	{
		Assert::same($array1, ArrayClass::from($array)->filter($callback)->toArray());
	}

}

testCase(new FilterTestCase);
