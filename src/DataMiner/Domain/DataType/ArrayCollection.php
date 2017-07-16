<?php

namespace Mpwar\DataMiner\Domain\DataType;

use ArrayAccess;
use Countable;
use InvalidArgumentException;
use Iterator;

abstract class ArrayCollection implements Countable, ArrayAccess, Iterator
{
    protected $items;

    public function __construct(...$items)
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add($item): void
    {
        $this->validateType($item, $this->typeOfCollection());
        $this->items[] = $item;
    }

    private function validateType($item, $type): void
    {
        if (!$item instanceof $type) {
            throw new InvalidArgumentException(
                sprintf(
                    'Type of argument expected : %s',
                    $type
                )
            );
        }
    }

    abstract protected function typeOfCollection(): string;

    public function count(): int
    {
        return count($this->items);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        return;
    }

    public function offsetUnset($offset): void
    {
        return;
    }

    public function current()
    {
        return current($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        return (bool)current($this->items);
    }

    public function rewind(): void
    {
        reset($this->items);
    }
}
