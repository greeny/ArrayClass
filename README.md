# ArrayClass
An objective approach to arrays

## The goal
Have you ever used some of PHP's native `array_*` functions? Then you know that there is some inconsistency,
some of them just return new array, some modify the original one. And not even talking about parameter order
and default values.

Lets take this code:

```php

$array = [];
array_push($array, 0, 1, 2, 3);
shuffle($array);
$array = array_map(function ($item) {
	return $item * 2;
}, $array);
$array = array_filter($array);
print_r($array);

```

Can you tell from first look, what the code does? Well you probably can, but the code is messy.

However what if we rewrite the code like this:

```php

$array = ArrayClass::from([])
	->push(0, 1, 2, 3)
	->shuffle()
	->map(function ($item) {
		return $item * 2;
	})
	->filter()
	->toArray();
	
print_r($array);

```

Looks way more better, right? And quess what, it does the same thing as example above, using same functions,
but taking advantages from PHP 5's OOP; PHP 5.6's variadic arguments and other things.

One may argue that working with this class would not be the same as working with arrays, but I have solution for this too!

```php

$array = ArrayClass::from([]);

// you can count elements natively
count($array);

// iterate over elements
foreach ($array as $key => $value) {
	// do stuff
}

// and even modify some of them!
$array[1] = 4;
$array[2] = $array[3] * isset($array[4]) ? $array[4] : 4;
unset($array[5]);

```

So you do think it's everything I have for you? Wrong! Look at all these cool features built-in:

- stricter code (every comparsion is done by `===` instead of `==`, that counts also for `in_array`, `search` and `keys`)
- bigger array-like support: every method that works with plain arrays can also accept `ArrayClass` or object implementing `Traversable`
- cloning using `$arrayClass->cloneArray()` to return fresh clone or `$arrayClass->cloneRef($original)` to save original one and return clone
- automatic callback checking, throws exception when passed callback is not callable
- nice and easy readable API with fluent interface
- conversion to plain array with `toArray()` method
- and much more!

## Method index

Almost all of methods provided by `ArrayClass` just wrap some native PHP function for working with arrays.
If yes, only the name of wrapped PHP function is included, parameters are the same as for original function
(except first array parameter, which is the array you are currently working with, represented by `ArrayClass`).

- `changeKeyCase` (`$case`) = `array_change_key_case`
- `chunk` (`$size, $preserveKeys = FALSE`) = `array_chunk`
- `column` (`$key, $indexKey = NULL`) = `array_column`
- `countValues` = `array_count_values`
- `diffAssoc` (`...$array`) = `array_diff_assoc`
- `diffKey` (`...$array`) = `array_diff_key`
- `diffUassoc` (`$callback, ...$array`) = `array_diff_uassoc`
- `diff` (`...$array`) = `array_diff`
- `filter` (`$callback = NULL, $flags = 0`) = `array_filter`
- `flip` = `array_flip`
- `intersectAssoc` (`...$array`) = `array_intersect_assoc`
- `intersectKey` (`...$array`) = `array_intersect_key`
- `intersectUassoc` (`$callback, ...$array`) = `array_intersect_uassoc`
- `intersectUkey` (`$callback, ...$array`) = `array_intersect_ukey`
- `intersect` (`...$array`) = `array_intersect`
- `keyExists` (`$key`) = `array_key_exists`
- `keys` (`$search = NULL, $strict = TRUE`) = `array_keys`
- `map` (`$callback, ...$array`) = `array_map`
- `mergeRecursive` (`...$array`) = `array_merge_recursive`
- `merge` (`...$array`) = `array_merge`
- `multisort` (`$order = SORT_ASC, $flags = SORT_REGULAR, ...$args`) = `array_multisort`
- `pad` (`$size, $value`) = `array_pad`
- `pop` = `array_pop`
- `product` = `array_product`
- `push` (`...$values`) = `array_push`
- `rand` (`$num = 1`) = `array_rand`
- `reduce` (`$callback, $initial = NULL`) = `array_reduce`
- `replaceRecursive` (`...$array`) = `array_replace_recursive`
- `replace` (`...$array`) = `array_replace`
- `reverse` (`$preserveKeys = FALSE`) = `array_reverse`
- `search` (`$needle, $strict = TRUE`) = `array_search`
- `shift` = `array_shift`
- `slice` (`$offset, $length = NULL, $preserveKeys = FALSE`) = `array_slice`
- `splice` (`$offset, $length = 0, $replacement = []`) = `array_splice`
- `sum` = `array_sum`
- `udiffAssoc` (`$callable, ...$array`) = `array_udiff_assoc`
- `udiffUassoc` (`$valueCallable, $keyCallable, ...$array`) = `array_udiff_uassoc`
- `udiff` (`$callable, ...$array`) = `array_udiff`
- `uintersectAssoc` (`$callable, ...$array`) = `array_uintersect_assoc`
- `uintersectUassoc` (`$valueCallable, $keyCallable, ...$array`) = `array_uintersect_uassoc`
- `uintersect` (`$callable, ...$array`) = `array_uintersect`
- `unique` (`$sort = SORT_STRING`) = `array_unique`
- `unshift` (`...$value`) = `array_unshift`
- `values` = `array_values`
- `walkRecursive` (`$callback, $userData = NULL`) = `array_walk_recursive`
- `walk` (`$callback, $userData = NULL`) = `array_walk`
- `arsort` (`$sort = SORT_REGULAR`) = `arsort`
- `asort` (`$sort = SORT_REGULAR`) = `asort`
- `current` = `current`
- `each` = `each`
- `end` = `end`
- `has` (`$needle, $strict = TRUE`) = `in_array`
- `key` = `key`
- `krsort` (`$sort = SORT_REGULAR`) = `krsort`
- `ksort` (`$sort = SORT_REGULAR`) = `ksort`
- `natCaseSort` = `natcasesort`
- `natSort` = `natsort`
- `next` = `next`
- `prev` = `prev`
- `reset` = `reset`
- `rsort` (`$sort = SORT_REGULAR`) = `rsort`
- `shuffle` = `shuffle`
- `sort` (`$sort = SORT_REGULAR`) = `sort`
- `uasort` (`$callable`) = `uasort`
- `uksort` (`$callable`) = `uksort`
- `usort` (`$callable`) = `usort`

Also there are some utility methods:

- `combineKeysWith` (`$values`) - equals to calling `array_combine($array, $values)`
- `combineValuesWith` (`$keys`) = equals to calling `array_combine($keys, $array)`
- `cloneArray` - returns clone of `ArrayClass`
- `cloneRef` (`&$ref`) - returns clone of `ArrayClass`, also sets original `ArrayClass` to `$ref`
- `toArray` - converts `ArrayClass` to native array

## So what are you waiting for?

Ah, you maybe do not know, how to initialize that thing?

Well, simply copy the `ArrayClass.php` file to your working directory and require it:

```php

require_once __DIR__ . '/ArrayClass.php'; // path to most awesome library ever

```

Or install it with composer (`composer require greeny/array-class`) and use composer autoloader:


```php

require_once __DIR__ . '/vendor/autoload.php';

```

Then you can start enjoying it!

```php

// import class
use greeny\ArrayClass\ArrayClass; // yes, I know, weird namespace

$array = new ArrayClass; // initializes from empty array
$array = new ArrayClass($original); // initializes from original array
$array = ArrayClass::from($original); // same as before, good for chaining methods immidiatelly, like below:

$array = ArrayClass::from($original)->filter()->shuffle(); // etc etc

```

## Comming soon (maybe)

- unit tests (there **may** (but **should not**) be some not yet discovered bugs)
- any ideas? Let me know by opening an issue!
