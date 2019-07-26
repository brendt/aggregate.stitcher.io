<?php

namespace Support;

interface Polymorphic
{
    public function getMorphClass();

    public function getKey();
}
