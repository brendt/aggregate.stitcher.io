<?php

namespace App\Support;

interface Factory
{
    public function make(int $i = 0): object;

    /** @return FactoryCollection<self> */
    public function times(int $times): FactoryCollection;
}