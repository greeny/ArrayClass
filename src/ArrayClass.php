<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\ArrayClass;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use Traversable;


class ArrayClass implements IteratorAggregate, Countable, ArrayAccess
{

	/** @var array */
	private $array = [];


	/*
	 * ================
	 * = Constructors =
	 * ================
	 */


	/**
	 * @param array|Traversable|ArrayClass $array
	 */
	public function __construct($array = [])
	{
		$this->array = self::convertToArray($array);
	}


	/**
	 * @param array|Traversable|ArrayClass $array
	 * @return ArrayClass
	 */
	public static function from($array)
	{
		return new self($array);
	}


	/*
	 * =================================
	 * = PHP functions implementations =
	 * =================================
	 */


	/**
	 * @param $case
	 * @return $this
	 */
	public function changeKeyCase($case)
	{
		$this->array = array_change_key_case($this->array, $case);
		return $this;
	}


	/**
	 * @param int $size
	 * @param bool $preserveKeys
	 * @return $this
	 */
	public function chunk($size, $preserveKeys = FALSE)
	{
		$this->array = array_chunk($this->array, $size, $preserveKeys);
		return $this;
	}


	/**
	 * @param string $key
	 * @param string|NULL $indexKey
	 * @return $this
	 */
	public function column($key, $indexKey = NULL)
	{
		$this->array = array_column($this->array, $key, $indexKey);
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass $keys
	 * @param array|Traversable|ArrayClass $values
	 * @return ArrayClass
	 */
	public static function combine($keys, $values)
	{
		return self::convertToSelf(array_combine(self::convertToArray($keys), self::convertToArray($values)));
	}


	/**
	 * @param array|Traversable|ArrayClass $values
	 * @return $this
	 */
	public function combineKeysWith($values)
	{
		$this->array = self::combine($this->array, $values)->toArray();
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass $keys
	 * @return $this
	 */
	public function combineValuesWith($keys)
	{
		$this->array = self::combine($keys, $this->array)->toArray();
		return $this;
	}


	/**
	 * @return ArrayClass
	 */
	public function countValues()
	{
		$this->array = array_count_values($this->array);
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function diffAssoc(...$array)
	{
		$this->array = array_diff_assoc($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function diffKey(...$array)
	{
		$this->array = array_diff_key($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param callable $callback
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function diffUassoc($callback, ...$array)
	{
		self::checkCallback($callback);
		$this->array = array_diff_uassoc($this->array, ...array_merge(self::convertMoreToArray($array), [$callback]));
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function diff(...$array)
	{
		$this->array = array_diff($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass $array
	 * @param mixed $value
	 * @return ArrayClass
	 */
	public static function fillKeys($array, $value)
	{
		$array = self::convertToArray($array);
		return self::convertToSelf(array_fill_keys($array, $value));
	}


	/**
	 * @param int $start
	 * @param int $num
	 * @param mixed $value
	 * @return ArrayClass
	 */
	public static function fill($start, $num, $value)
	{
		return self::convertToSelf(array_fill($start, $num, $value));
	}


	/**
	 * @param callable $callback
	 * @param int $flags
	 * @return $this
	 */
	public function filter($callback = NULL, $flags = 0)
	{
		self::checkCallback($callback, TRUE);
		$callback = $callback ?: function ($item) {
			return (bool) $item;
		};
		$this->array = array_filter($this->array, $callback, $flags);
		return $this;
	}


	/**
	 * @return $this
	 */
	public function flip()
	{
		$this->array = array_flip($this->array);
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function intersectAssoc(...$array)
	{
		$this->array = array_intersect_assoc($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function intersectKey(...$array)
	{
		$this->array = array_intersect_key($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param callable $callback
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function intersectUassoc($callback, ...$array)
	{
		self::checkCallback($callback);
		$this->array = array_intersect_uassoc($this->array, ...array_merge(self::convertMoreToArray($array), [$callback]));
		return $this;
	}


	/**
	 * @param callable $callback
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function intersectUkey($callback, ...$array)
	{
		self::checkCallback($callback);
		$this->array = array_intersect_ukey($this->array, ...array_merge(self::convertMoreToArray($array), [$callback]));
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function intersect(...$array)
	{
		$this->array = array_intersect($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param mixed $key
	 * @return bool
	 */
	public function keyExists($key)
	{
		return array_key_exists($key, $this->array);
	}


	/**
	 * @param mixed $search
	 * @param bool $strict
	 * @return $this
	 */
	public function keys($search = NULL, $strict = TRUE)
	{
		$this->array = array_keys($this->array, $search, $strict);
		return $this;
	}


	/**
	 * @param callable $callback
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function map($callback, ...$array)
	{
		self::checkCallback($callback);
		$this->array = array_map($callback, $this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function mergeRecursive(...$array)
	{
		$this->array = array_merge_recursive($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function merge(...$array)
	{
		$this->array = array_merge($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param int $order
	 * @param int $flags
	 * @param mixed ...$args
	 * @return $this
	 */
	public function multisort($order = SORT_ASC, $flags = SORT_REGULAR, ...$args)
	{
		array_multisort($this->array, $order, $flags, ...$args);
		return $this;
	}


	/**
	 * @param int $size
	 * @param mixed $value
	 * @return $this
	 */
	public function pad($size, $value)
	{
		$this->array = array_pad($this->array, $size, $value);
		return $this;
	}


	/**
	 * @return mixed
	 */
	public function pop()
	{
		return array_pop($this->array);
	}


	/**
	 * @return int|float
	 */
	public function product()
	{
		return array_product($this->array);
	}


	/**
	 * @param array|Traversable|ArrayClass ...$values
	 * @return $this
	 */
	public function push(...$values)
	{
		array_push($this->array, ...$values);
		return $this;
	}


	/**
	 * @param int $num
	 * @return $this
	 */
	public function rand($num = 1)
	{
		if ($num > count($this->array)) {
			return self::convertToSelf($this->array);
		}
		$this->array = array_rand($this->array, $num);
		return $this;
	}


	/**
	 * @param callable $callback
	 * @param mixed $initial
	 * @return mixed
	 */
	public function reduce($callback, $initial = NULL)
	{
		self::checkCallback($callback);
		return array_reduce($this->array, $callback, $initial);
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function replaceRecursive(...$array)
	{
		$this->array = array_replace_recursive($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function replace(...$array)
	{
		$this->array = array_replace($this->array, ...self::convertMoreToArray($array));
		return $this;
	}


	/**
	 * @param bool $preserveKeys
	 * @return $this
	 */
	public function reverse($preserveKeys = FALSE)
	{
		$this->array = array_reverse($this->array, $preserveKeys);
		return $this;
	}


	/**
	 * @param mixed $needle
	 * @param bool $strict
	 * @return mixed
	 */
	public function search($needle, $strict = TRUE)
	{
		return array_search($needle, $this->array, $strict);
	}


	/**
	 * @return mixed
	 */
	public function shift()
	{
		return array_shift($this->array);
	}


	/**
	 * @param int $offset
	 * @param int $length
	 * @param bool $preserveKeys
	 * @return $this
	 */
	public function slice($offset, $length = NULL, $preserveKeys = FALSE)
	{
		$this->array = array_slice($this->array, $offset, $length, $preserveKeys);
		return $this;
	}


	/**
	 * @param int $offset
	 * @param int $length
	 * @param array|Traversable|ArrayClass $replacement
	 * @return $this
	 */
	public function splice($offset, $length = 0, $replacement = [])
	{
		$this->array = array_splice($this->array, $offset, $length, self::convertToArray($replacement));
		return $this;
	}


	/**
	 * @return int|float
	 */
	public function sum()
	{
		return array_sum($this->array);
	}


	/**
	 * @param callable $callable
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function udiffAssoc($callable, ...$array)
	{
		self::checkCallback($callable);
		$this->array = call_user_func_array('array_udiff_assoc', array_merge([$this->array], self::convertMoreToArray($array), [$callable]));
		return $this;
	}


	/**
	 * @param callable $valueCallable
	 * @param callable $keyCallable
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function udiffUassoc($valueCallable, $keyCallable, ...$array)
	{
		self::checkCallback($keyCallable);
		self::checkCallback($valueCallable);
		$this->array = call_user_func_array('array_udiff_uassoc', array_merge([$this->array], self::convertMoreToArray($array), [$valueCallable, $keyCallable]));
		return $this;
	}


	/**
	 * @param callable $callable
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function udiff($callable, ...$array)
	{
		self::checkCallback($callable);
		$this->array = call_user_func_array('array_udiff', array_merge([$this->array], self::convertMoreToArray($array), [$callable]));
		return $this;
	}


	/**
	 * @param callable $callable
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function uintersectAssoc($callable, ...$array)
	{
		self::checkCallback($callable);
		$this->array = call_user_func_array('array_uintersect_assoc', array_merge([$this->array], self::convertMoreToArray($array), [$callable]));
		return $this;
	}


	/**
	 * @param callable $valueCallable
	 * @param callable $keyCallable
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function uintersectUassoc($valueCallable, $keyCallable, ...$array)
	{
		self::checkCallback($keyCallable);
		self::checkCallback($valueCallable);
		$this->array = call_user_func_array('array_uintersect_uassoc', array_merge([$this->array], self::convertMoreToArray($array), [$valueCallable, $keyCallable]));
		return $this;
	}


	/**
	 * @param callable $callable
	 * @param array|Traversable|ArrayClass ...$array
	 * @return $this
	 */
	public function uintersect($callable, ...$array)
	{
		self::checkCallback($callable);
		$this->array = call_user_func_array('array_uintersect', array_merge([$this->array], self::convertMoreToArray($array), [$callable]));
		return $this;
	}


	/**
	 * @param int $sort
	 * @return $this
	 */
	public function unique($sort = SORT_STRING)
	{
		$this->array = array_unique($this->array, $sort);
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass ...$value
	 * @return $this
	 */
	public function unshift(...$value)
	{
		array_unshift($this->array, ...$value);
		return $this;
	}


	/**
	 * @return $this
	 */
	public function values()
	{
		$this->array = array_values($this->array);
		return $this;
	}


	/**
	 * @param callback $callback
	 * @param mixed $userData
	 * @return $this
	 */
	public function walkRecursive($callback, $userData = NULL)
	{
		self::checkCallback($callback);
		array_walk_recursive($this->array, $callback, $userData);
		return $this;
	}


	/**
	 * @param callback $callback
	 * @param mixed $userData
	 * @return $this
	 */
	public function walk($callback, $userData = NULL)
	{
		self::checkCallback($callback);
		array_walk($this->array, $callback, $userData);
		return $this;
	}


	/**
	 * @param int $sort
	 * @return $this
	 */
	public function arsort($sort = SORT_REGULAR)
	{
		arsort($this->array, $sort);
		return $this;
	}


	/**
	 * @param int $sort
	 */
	public function asort($sort = SORT_REGULAR)
	{
		asort($this->array, $sort);
	}


	/**
	 * @return mixed
	 */
	public function current()
	{
		return current($this->array);
	}


	/**
	 * @return ArrayClass
	 */
	public function each()
	{
		return self::convertToSelf(each($this->array));
	}


	/**
	 * @return mixed
	 */
	public function end()
	{
		return end($this->array);
	}


	/**
	 * @param mixed $needle
	 * @param bool $strict
	 * @return bool
	 */
	public function has($needle, $strict = TRUE)
	{
		return in_array($needle, $this->array, $strict);
	}


	/**
	 * @return mixed
	 */
	public function key()
	{
		return key($this->array);
	}


	/**
	 * @param int $sort
	 * @return $this
	 */
	public function krsort($sort = SORT_REGULAR)
	{
		krsort($this->array, $sort);
		return $this;
	}


	/**
	 * @param int $sort
	 * @return $this
	 */
	public function ksort($sort = SORT_REGULAR)
	{
		ksort($this->array, $sort);
		return $this;
	}


	/**
	 * @return $this
	 */
	public function natCaseSort()
	{
		natcasesort($this->array);
		return $this;
	}


	/**
	 * @return $this
	 */
	public function natSort()
	{
		natsort($this->array);
		return $this;
	}


	/**
	 * @return mixed
	 */
	public function next()
	{
		return next($this->array);
	}


	/**
	 * @return mixed
	 */
	public function prev()
	{
		return prev($this->array);
	}


	/**
	 * @param mixed $start
	 * @param mixed $end
	 * @param int $step
	 * @return ArrayClass
	 */
	public static function range($start, $end, $step = 1)
	{
		return self::convertToSelf(range($start, $end, $step));
	}


	/**
	 * @return mixed
	 */
	public function reset()
	{
		return reset($this->array);
	}


	/**
	 * @param int $sort
	 * @return $this
	 */
	public function rsort($sort = SORT_REGULAR)
	{
		rsort($this->array, $sort);
		return $this;
	}


	/**
	 * @return $this
	 */
	public function shuffle()
	{
		shuffle($this->array);
		return $this;
	}


	/**
	 * @param int $sort
	 * @return $this
	 */
	public function sort($sort = SORT_REGULAR)
	{
		sort($this->array, $sort);
		return $this;
	}


	/**
	 * @param callable $callable
	 * @return $this
	 */
	public function uasort($callable)
	{
		self::checkCallback($callable);
		uasort($this->array, $callable);
		return $this;
	}


	/**
	 * @param callable $callable
	 * @return $this
	 */
	public function uksort($callable)
	{
		self::checkCallback($callable);
		uksort($this->array, $callable);
		return $this;
	}


	/**
	 * @param callable $callable
	 * @return $this
	 */
	public function usort($callable)
	{
		self::checkCallback($callable);
		usort($this->array, $callable);
		return $this;
	}


	/**
	 * @return ArrayClass
	 */
	public function cloneArray()
	{
		return self::convertToSelf($this->array);
	}


	/**
	 * @param mixed $ref
	 * @return ArrayClass
	 */
	public function cloneRef(&$ref)
	{
		$ref = $this;
		return $this->cloneArray();
	}


	/*
	 * =========
	 * = Utils =
	 * =========
	 */


	/**
	 * @return array
	 */
	public function toArray()
	{
		return $this->array;
	}


	/**
	 * @param mixed $index
	 * @return mixed
	 */
	public function getIndex($index)
	{
		return $this->array[$index];
	}


	/**
	 * @param mixed $index
	 * @param mixed $value
	 * @return $this
	 */
	public function setIndex($index, $value)
	{
		$this->array[$index] = $value;
		return $this;
	}


	/**
	 * @param mixed $index
	 * @return bool
	 */
	public function issetIndex($index)
	{
		return isset($this->array[$index]);
	}


	/**
	 * @param mixed $index
	 * @return $this
	 */
	public function unsetIndex($index)
	{
		unset($this->array[$index]);
		return $this;
	}


	/**
	 * @param array|Traversable|ArrayClass $arg
	 * @return array
	 */
	private static function convertToArray($arg)
	{
		if ($arg instanceof self) {
			return $arg->toArray();
		} elseif ($arg instanceof Traversable) {
			return iterator_to_array($arg);
		}
		return (array) $arg;
	}


	/**
	 * @param array|Traversable|ArrayClass $array
	 * @return array[]
	 */
	private static function convertMoreToArray($array)
	{
		$result = [];
		foreach ($array as $key => $value) {
			$result[$key] = self::convertToArray($value);
		}
		return $result;
	}


	/**
	 * @param array|Traversable|ArrayClass $array
	 * @return ArrayClass
	 */
	private static function convertToSelf($array)
	{
		return new ArrayClass($array);
	}


	/**
	 * @param callable $callback
	 * @param bool $orNull
	 * @throws Exception
	 */
	private static function checkCallback($callback, $orNull = FALSE)
	{
		if (is_null($callback) && $orNull) {
			return;
		}
		if (!is_callable($callback)) {
			throw new Exception('Callback is not callable.');
		}
	}


	/*
	 * ==============
	 * = Interfaces =
	 * ==============
	 */


	/**
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->array);
	}


	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->array);
	}


	/**
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return $this->issetIndex($offset);
	}


	/**
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->getIndex($offset);
	}


	/**
	 * @param mixed $offset
	 * @param mixed $value
	 * @return $this
	 */
	public function offsetSet($offset, $value)
	{
		return $this->setIndex($offset, $value);
	}


	/**
	 * @param mixed $offset
	 * @return $this
	 */
	public function offsetUnset($offset)
	{
		return $this->unsetIndex($offset);
	}


	/*
	 * =================
	 * = Object access =
	 * =================
	 */


	/**
	 * @param mixed $name
	 * @param mixed $value
	 * @return $this
	 */
	public function __set($name, $value)
	{
		return $this->setIndex($name, $value);
	}


	/**
	 * @param mixed $name
	 * @return mixed
	 */
	public function __get($name)
	{
		return $this->getIndex($name);
	}


	/**
	 * @param mixed $name
	 * @return bool
	 */
	public function __isset($name)
	{
		return $this->issetIndex($name);
	}


	/**
	 * @param string $name
	 * @return $this
	 */
	public function __unset($name)
	{
		return $this->unsetIndex($name);
	}


}
