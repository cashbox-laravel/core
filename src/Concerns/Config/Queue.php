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

namespace CashierProvider\Core\Concerns\Config;

use CashierProvider\Core\Concerns\Config\Payment\Drivers;
use CashierProvider\Core\Data\Config\Queue\QueueData;
use CashierProvider\Core\Data\Config\Queue\QueueNameData;
use CashierProvider\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;

trait Queue
{
    use Drivers;

    protected static function queue(): QueueData
    {
        return Config::queue();
    }

    protected static function queueName(?Model $payment = null): QueueNameData
    {
        if ($payment) {
            return static::driverByModel($payment)->getQueue();
        }

        return static::queue()->name;
    }
}
