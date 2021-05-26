<?php

namespace Helldar\Cashier\Helpers\Config;

final class Main extends Base
{
    public function hasProduction(): bool
    {
        return config('cashier.environment') === 'production';
    }

    public function logger(): ?string
    {
        return config('cashier.logger');
    }

    public function queue(): ?string
    {
        return config('cashier.queue');
    }
}
