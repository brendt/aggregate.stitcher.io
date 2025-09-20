<?php

namespace App\Support;

trait IsFactory
{
    /** @return FactoryCollection<self> */
    public function times(int $times): FactoryCollection
    {
        return new FactoryCollection($this)->times($times);
    }
}