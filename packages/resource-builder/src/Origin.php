<?php

declare(strict_types=1);

namespace Medz\GBT2260\ResourceBuilder;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Traversable;
use Symfony\Component\Yaml\Parser;

class Origin implements ArrayAccess, IteratorAggregate
{
	/**
	 * The static is origin value
	 *
	 * @var array
	 */
	protected static $origin;

	/**
	 * Create the class instance.
	 *
	 * @param  \Symfony\Component\Yaml\Parser $parser
	 *
	 */
	public function __construct(Parser $parser)
	{
		// 如果加载过数据，则不执行加载，避免损耗！
		if (!static::$origin) {
			static::$origin = $parser->parseFile(
				ResourceDefinition::ORIGIN_FILENAME
			);
		}
	}

	/**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return static::$origin[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            static::$origin[] = $value;
        } else {
            static::$origin[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset(static::$origin[$key]);
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator(static::$origin);
    }
}
