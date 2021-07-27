<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Config;

use Helldar\Contracts\Cashier\Config\Details as DetailsContract;

class Details extends Base implements DetailsContract
{
    public function getTable(): string
    {
        return config('cashier.details.table');
    }
}
