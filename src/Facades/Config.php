<?php

declare(strict_types=1);

namespace CashierProvider\Core\Facades;

use CashierProvider\Core\Data\Config\Check;
use CashierProvider\Core\Data\Config\Config as ConfigData;
use CashierProvider\Core\Data\Config\Details;
use CashierProvider\Core\Data\Config\Driver;
use CashierProvider\Core\Data\Config\Logs;
use CashierProvider\Core\Data\Config\Payment\Payment;
use CashierProvider\Core\Data\Config\Queue;
use CashierProvider\Core\Data\Config\Refund;
use Illuminate\Support\Facades\Facade;
use Spatie\LaravelData\DataCollection;

/**
 * @method static bool isProduction()
 * @method static Check check()
 * @method static DataCollection drivers()
 * @method static Details details()
 * @method static Driver getDriver(string|int $name)
 * @method static Logs logs()
 * @method static Payment payment()
 * @method static Queue queue()
 * @method static Refund refund()
 */
class Config extends Facade
{
    protected static function getFacadeAccessor(): ConfigData
    {
        return ConfigData::from(config('cashier'));
    }
}
