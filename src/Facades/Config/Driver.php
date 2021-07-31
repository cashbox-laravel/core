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

namespace Helldar\Cashier\Facades\Config;

use Helldar\Cashier\Config\Driver as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getDriver()
 * @method static string getDetails()
 * @method static string|null getClientId()
 * @method static string|null getClientSecret()
 */
class Driver extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
