<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class IntersectUkeyTestCase extends TestCase
{

	public function dataProvider()
	{
		$master = [
			'a' => 1,
			'b' => 2,
			'c' => 4,
		];

		$callable = function ($a1, $a2) {
			$a2 += 1;
			return ($a1 > $a2) ? 1 : (($a1 < $a2) ? -1 : 0);
		};

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
				array_intersect_ukey($array, $master, $callable),
				$master,
				$callable,
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testIntersectUkey($array, $array1, $master, $callable)
	{
		Assert::same($array1, ArrayClass::from($array)->intersectUkey($callable, $master)->toArray());
	}

}

testCase(new IntersectUkeyTestCase);
