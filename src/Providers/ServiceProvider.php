<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace CashierProvider\Manager\Providers;

use CashierProvider\Manager\Console\Commands\Check;
use CashierProvider\Manager\Console\Commands\Refund;
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
            __DIR__ . '/../../config/cashier.php' => $this->app->configPath('cashier.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../database/migrations/public' => $this->app->databasePath('migrations'),
        ], 'migrations');
    }

    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/main');
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
        $this->mergeConfigFrom(__DIR__ . '/../../config/cashier.php', 'cashier');
    }
}
