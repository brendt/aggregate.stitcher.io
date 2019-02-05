<?php

namespace Tests\Mocks;

trait IterableImplementation
{
    protected $position = 0;

    protected $array = [];

    public function offsetGet($offset)
    {
        return $this->array[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->array[] = $value;

            return;
        }

        $this->array[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->array);
    }

    public function offsetUnset($offset): void
    {
        unset($this->array[$offset]);
    }

    public function current()
    {
        return $this->array[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return array_key_exists($this->position, $this->array);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        return count($this->array);
    }
}
