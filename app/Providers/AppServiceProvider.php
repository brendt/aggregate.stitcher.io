<?php

namespace App\Providers;

use App\Support\QueryFilter;
use Illuminate\Http\Request;
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

        $this->app->singleton(QueryFilter::class, function () {
            /** @var \Illuminate\Http\Request $request */
            $request = $this->app->get(Request::class);

            return new QueryFilter($request->getRequestUri());
        });
    }
}
