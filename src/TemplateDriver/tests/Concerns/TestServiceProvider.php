<?php

declare(strict_types=1);

namespace Tests\Concerns;

use CashierProvider\Core\Providers\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../database/migrations',
            __DIR__ . '/../../vendor/cashier-provider/core/database/migrations/main',
        ]);
    }
}
