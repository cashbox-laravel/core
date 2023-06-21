<?php

declare(strict_types=1);

namespace CashierProvider\Core\Facades;

use CashierProvider\Core\Data\Config\CheckData;
use CashierProvider\Core\Data\Config\ConfigData as ConfigData;
use CashierProvider\Core\Data\Config\DriverData;
use CashierProvider\Core\Data\Config\LogsData;
use CashierProvider\Core\Data\Config\Payment\PaymentData;
use CashierProvider\Core\Data\Config\Queue\QueueData;
use CashierProvider\Core\Data\Config\RefundData;
use CashierProvider\Core\Data\Config\TableData;
use Illuminate\Support\Facades\Facade;
use Spatie\LaravelData\DataCollection;

/**
 * @method static bool isProduction()
 * @method static CheckData check()
 * @method static TableData connection()
 * @method static DataCollection drivers()
 * @method static DriverData driver(string|int $name)
 * @method static LogsData logs()
 * @method static PaymentData payment()
 * @method static QueueData queue()
 * @method static RefundData refund()
 */
class Config extends Facade
{
    protected static function getFacadeAccessor(): ConfigData
    {
        return ConfigData::from(config('cashier'));
    }
}
