<?php

declare(strict_types=1);

namespace Helldar\Cashier\Facades\Config\Payments;

use Helldar\Cashier\Config\Payments\Statuses as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getAll()
 * @method static string|int getStatus(string $status)
 */
class Statuses extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
