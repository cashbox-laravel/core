<?php

namespace Helldar\Cashier\Helpers\Config;

class Main extends Base
{
    public function hasProduction(): bool
    {
        return config('app.env') === 'production';
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
