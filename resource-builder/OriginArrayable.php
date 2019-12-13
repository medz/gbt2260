<?php

declare(strict_types=1);

namespace Medz\GBT2260\ResourceBuilder;

use ArrayIterator;
use IteratorAggregate;

class OriginArrayable implements IteratorAggregate
{
    protected $path;
    protected $resource;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->resource = json_decode(file_get_contents($path), true);
    }

    public function __get($key)
    {
        return $this->resource[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->resource[$key] = $value;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function save()
    {
        file_put_contents($this->path, json_encode($this->resource, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->resource);
    }
}
