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

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Facades\Helpers\JSON;
use DragonCode\Support\Facades\Helpers\Arr;

/** @mixin \DragonCode\Contracts\Support\Arrayable */
trait Jsonable
{
    public function toJson(int $options = 0): string
    {
        return JSON::encode(Arr::filter($this->toArray()));
    }
}
