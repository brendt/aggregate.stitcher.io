<?php

namespace Domain\User\Events;

interface SendsVerificationEvent
{
    public function getUserUuid(): string;
}
