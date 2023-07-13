<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core\Providers;

use Cashbox\Core\Console\Commands\Refund;
use Cashbox\Core\Console\Commands\Verify;

class ServiceProvider extends BaseProvider
{
    public function boot(): void
    {
        if ($this->disabled()) {
            return;
        }

        $this->bootMigrations();
        $this->bootPublishes();
        $this->bootCommands();
    }

    public function register(): void
    {
        if ($this->disabled()) {
            return;
        }

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
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations/private');
    }

    protected function bootCommands(): void
    {
        $this->commands([
            Verify::class,
            Refund::class,
        ]);
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/cashier.php', 'cashier');
    }
}
