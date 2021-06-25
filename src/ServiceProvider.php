<?php

namespace Helldar\Cashier;

use Helldar\Cashier\Console\Commands\Check;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->bootMigrations();

        if ($this->allowRunning()) {
            $this->bootPublishes();
            $this->bootCommands();
        }
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
        $this->commands([Check::class]);
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cashier.php', 'cashier');
    }

    protected function allowRunning(): bool
    {
        return $this->app->runningInConsole() || $this->app->runningUnitTests();
    }
}
