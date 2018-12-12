<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\BladeX\BladeX;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /** @var \Spatie\BladeX\BladeX $bladeX */
        $bladeX = $this->app->get(BladeX::class);

        $bladeX->component([
            'components.*',
            'components.form.*',
        ]);
    }

    public function register()
    {
        $this->app->alias('bugsnag.multi', \Psr\Log\LoggerInterface::class);
        $this->app->alias('bugsnag.multi', \Psr\Log\LoggerInterface::class);
    }
}
