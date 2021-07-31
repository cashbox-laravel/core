<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Config;

use Helldar\Cashier\Config\Payments\Attributes;
use Helldar\Cashier\Config\Payments\Map;
use Helldar\Cashier\Config\Payments\Statuses;
use Helldar\Contracts\Cashier\Config\Payment as PaymentContract;
use Helldar\Contracts\Cashier\Config\Payments\Attributes as AttributesContract;
use Helldar\Contracts\Cashier\Config\Payments\Map as MapContract;
use Helldar\Contracts\Cashier\Config\Payments\Statuses as StatusesContract;

class Payment extends Base implements PaymentContract
{
    public function getModel(): string
    {
        return config('cashier.payment.model');
    }

    public function getAttributes(): AttributesContract
    {
        $values = config('cashier.payment.attributes');

        return Attributes::make($values);
    }

    public function getStatuses(): StatusesContract
    {
        $statuses = config('cashier.payment.statuses', []);

        return Statuses::make(compact('statuses'));
    }

    public function getMap(): MapContract
    {
        $drivers = config('cashier.payment.map', []);

        return Map::make(compact('drivers'));
    }
}
