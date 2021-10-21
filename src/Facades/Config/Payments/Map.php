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

namespace CashierProvider\Core\Facades\Config\Payments;

use CashierProvider\Core\Config\Payments\Map as Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getAll()
 * @method static array getTypes()
 * @method static array getNames()
 * @method static string get(string $type)
 */
class Map extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Config::class;
    }
}
