<?php

/*
 * This file is part of the "cashier-provider/core" project.
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
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Config;

use CashierProvider\Core\Config\Payments\Attributes;
use CashierProvider\Core\Config\Payments\Map;
use CashierProvider\Core\Config\Payments\Statuses;
use DragonCode\Contracts\Cashier\Config\Payment as PaymentContract;
use DragonCode\Contracts\Cashier\Config\Payments\Attributes as AttributesContract;
use DragonCode\Contracts\Cashier\Config\Payments\Map as MapContract;
use DragonCode\Contracts\Cashier\Config\Payments\Statuses as StatusesContract;

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
