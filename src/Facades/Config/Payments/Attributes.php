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

namespace Helldar\Cashier\Facades\Config\Payments;

use Helldar\Cashier\Config\Payments\Attributes as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getType()
 * @method static string getStatus()
 */
class Attributes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
