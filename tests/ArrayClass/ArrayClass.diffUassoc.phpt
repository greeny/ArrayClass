<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class DiffUassocTestCase extends TestCase
{

	public function dataProvider()
	{
		$master = [1, 3, 5];

		$callable = function ($a1, $a2) {
			$a2 += 1;
			return ($a1 > $a2) ? 1 : (($a1 < $a2) ? -1 : 0);
		};

		$arrays = [
			[2, 4, 6, 8, 10],
			[4, 6, 8],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_diff_uassoc($array, $master, $callable),
				$master,
				$callable,
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testDiffUassoc($array, $array1, $master, $callable)
	{
		Assert::same($array1, ArrayClass::from($array)->diffUassoc($callable, $master)->toArray());
		Assert::same($array1, ArrayClass::from($array)->diffUassoc($callable, ArrayClass::from($master))->toArray());
	}

}

testCase(new DiffUassocTestCase);
