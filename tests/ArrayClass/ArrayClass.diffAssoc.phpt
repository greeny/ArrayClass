<?php

require_once __DIR__ . "/../bootstrap.php";

use greeny\ArrayClass\ArrayClass;
use Tester\Assert;
use Tester\TestCase;


class DiffAssocTestCase extends TestCase
{

	public function dataProvider()
	{
		$master = [2, 3, 4];
		$arrays = [
			[1, 2, 3, 4, 5],
			[2, 3, 4],
		];

		foreach ($arrays as $array) {
			yield [
				$array,
				array_diff_assoc($array, $master),
				$master,
			];
		}
	}


	/**
	 * @dataProvider dataProvider
	 */
	public function testDiffAssoc($array, $array1, $master)
	{
		Assert::same($array1, ArrayClass::from($array)->diffAssoc($master)->toArray());
		Assert::same($array1, ArrayClass::from($array)->diffAssoc(ArrayClass::from($master))->toArray());
	}

}

testCase(new DiffAssocTestCase);
