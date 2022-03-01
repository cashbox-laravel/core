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

namespace CashierProvider\Core\Facades\Helpers;

use CashierProvider\Core\Helpers\Http as Helper;
use DragonCode\Contracts\Cashier\Http\Request;
use DragonCode\Contracts\Exceptions\Manager as ExceptionManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array request(Request $request, ExceptionManager $manager)
 */
class Http extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
