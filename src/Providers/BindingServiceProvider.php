<?php

declare(strict_types=1);

namespace Cashbox\Core\Providers;

use Cashbox\Core\Data\Config\ConfigData;
use Cashbox\Core\Exceptions\Internal\ConfigCannotBeEmptyException;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class BindingServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->bindConfig();
    }

    protected function bindConfig(): void
    {
        $this->app->singleton(ConfigData::class, function () {
            if ($config = config('cashbox')) {
                return ConfigData::from($config);
            }

            throw new ConfigCannotBeEmptyException();
        });
    }
}
