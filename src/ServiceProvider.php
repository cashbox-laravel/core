<?php

namespace Helldar\Cashier;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->bootPublishes();
    }

    public function register(): void
    {
        $this->registerConfig();
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/cashier.php' => $this->app->configPath('cashier.php'),
        ], 'config');
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cashier.php', 'cashier');
    }
}
