<?php

namespace Tests\Mocks;

use Illuminate\Mail\Mailer;

class MockMailer extends Mailer
{
    public function __construct()
    {
        // Nothing needed
    }

    public function send($view, array $data = [], $callback = null)
    {
        return;
    }
}
