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

namespace CashierProvider\Core\Facades\Config;

use CashierProvider\Core\Config\Payment as Config;
use CashierProvider\Core\Config\Payments\Attributes;
use CashierProvider\Core\Config\Payments\Map;
use CashierProvider\Core\Config\Payments\Statuses;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getModel()
 * @method static Attributes getAttributes()
 * @method static Statuses getStatuses()
 * @method static Map getMap()
 */
class Payment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Config::class;
    }
}
