<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class IntersectAssocTestCase extends TestCase
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
				array_intersect_assoc($array, $master),
				$master
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testIntersectAssoc($array, $array1, $master)
	{
		Assert::same($array1, ArrayClass::from($array)->intersectAssoc($master)->toArray());
	}

}

testCase(new IntersectAssocTestCase);
