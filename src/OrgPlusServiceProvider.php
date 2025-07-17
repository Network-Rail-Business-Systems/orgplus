<?php

namespace NetworkRailBusinessSystems\OrgPlus;

use Illuminate\Support\ServiceProvider;

class OrgPlusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'orgplus');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('orgplus.php'),
        ]);
    }
}
