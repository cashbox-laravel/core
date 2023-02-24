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

class Payment extends Base
{
    public function getModel(): string
    {
        return config('cashier.payment.model');
    }

    public function getAttributes(): Attributes
    {
        $values = config('cashier.payment.attributes');

        return Attributes::from($values);
    }

    public function getStatuses(): Statuses
    {
        $statuses = config('cashier.payment.statuses', []);

        return Statuses::from(compact('statuses'));
    }

    public function getMap(): Map
    {
        $drivers = config('cashier.payment.map', []);

        return Map::from(compact('drivers'));
    }
}
