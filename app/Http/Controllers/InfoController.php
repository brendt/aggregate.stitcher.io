<?php

namespace App\Http\Controllers;

final class InfoController
{
    public function __invoke()
    {
        phpinfo();
        exit;
    }
}
