<?php

declare(strict_types=1);

namespace Cashbox\Core\Providers;

use Cashbox\Core\Data\Config\ConfigData;
use Cashbox\Core\Exceptions\Internal\ConfigCannotBeEmptyException;

class BindingServiceProvider extends BaseProvider
{
    public function register(): void
    {
        if ($this->disabled()) {
            return;
        }

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
