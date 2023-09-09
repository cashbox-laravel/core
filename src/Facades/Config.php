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

namespace Cashbox\Core\Facades;

use Cashbox\Core\Data\Config\ConfigData;
use Illuminate\Support\Facades\Facade;

class Config extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ConfigData::class;
    }
}
