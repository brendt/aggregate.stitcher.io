<?php

namespace App\Http\Controllers;

final class AdminInfoController
{
    public function __invoke()
    {
        phpinfo();
        exit;
    }
}
