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

namespace CashierProvider\Core\Facades\Config;

use CashierProvider\Core\Config\Payment as Config;
use Helldar\Contracts\Cashier\Config\Payments\Attributes;
use Helldar\Contracts\Cashier\Config\Payments\Map;
use Helldar\Contracts\Cashier\Config\Payments\Statuses;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getModel()
 * @method static Attributes getAttributes()
 * @method static Statuses getStatuses()
 * @method static Map getMap()
 */
class Payment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
