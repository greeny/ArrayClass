<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class IntersectTestCase extends TestCase
{

	public function dataProvider()
	{
		$master = [
			'a' => 1,
			'b' => 2,
			'c' => 4,
		];

		$arrays = [
			[
				'a' => 2,
				'd' => 2,
				'c' => 3,
			]
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_intersect($array, $master),
				$master
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testIntersect($array, $array1, $master)
	{
		Assert::same($array1, ArrayClass::from($array)->intersect($master)->toArray());
	}

}

testCase(new IntersectTestCase);
