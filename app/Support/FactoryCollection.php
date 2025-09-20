<?php

namespace App\Support;

/**
 * @template T
 */
final class FactoryCollection
{
    private int $times = 1;

    public function __construct(
        private readonly Factory $factory,
    ) {}

    public function times(int $times): self
    {
        $clone = clone $this;

        $clone->times = $times;

        return $clone;
    }

    /**
     * @return T[]
     */
    public function make(): array
    {
        $items = [];

        foreach (range(1, $this->times) as $i) {
            $items[] = $this->factory->make($i);
        }

        return $items;
    }
}