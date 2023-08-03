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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Concerns\Config;

use Cashbox\Core\Concerns\Config\Payment\Drivers;
use Cashbox\Core\Data\Config\Queue\QueueData;
use Cashbox\Core\Data\Config\Queue\QueueNameData;
use Cashbox\Core\Facades\Config;
use Illuminate\Database\Eloquent\Model;

trait Queue
{
    use Drivers;

    protected static function queueConfig(): QueueData
    {
        return Config::queue();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model|\Cashbox\Core\Billable|null  $payment
     */
    protected static function queueName(?Model $payment = null): QueueNameData
    {
        if ($payment) {
            return static::driverByModel($payment)->getQueue();
        }

        return static::queueConfig()->name;
    }
}
