<?php

namespace Domain\Post\Collections;

use Illuminate\Database\Eloquent\Collection;

final class VoteCollection extends Collection
{
    use SpreadForPeriod;
}
