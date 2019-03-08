<?php

namespace Domain\User\Events;

use Domain\User\Models\User;

interface ChangeForUserEvent
{
    public function getUser(): User;
}
