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

namespace CashierProvider\Manager\Facades\Config\Payments;

use CashierProvider\Manager\Config\Payments\Statuses as Config;
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
