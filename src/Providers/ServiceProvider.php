<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Providers;

use Helldar\Cashier\Console\Commands\Check;
use Helldar\Cashier\Console\Commands\Refund;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->bootMigrations();
        $this->bootPublishes();
        $this->bootCommands();
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

        $this->publishes([
            __DIR__ . '/../database/migrations/public' => $this->app->databasePath('migrations'),
        ], 'migrations');
    }

    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/main');
    }

    protected function bootCommands(): void
    {
        $this->commands([
            Check::class,
            Refund::class,
        ]);
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cashier.php', 'cashier');
    }
}
