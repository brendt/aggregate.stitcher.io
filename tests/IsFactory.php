<?php

namespace Tests;

trait IsFactory
{
    /** @return FactoryCollection<self> */
    public function times(int $times): FactoryCollection
    {
        return new FactoryCollection($this)->times($times);
    }
}