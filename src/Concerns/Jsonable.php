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

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Facades\Helpers\JSON;
use Helldar\Support\Facades\Helpers\Arr;

/** @mixin \Helldar\Contracts\Support\Arrayable */
trait Jsonable
{
    public function toJson(int $options = 0): string
    {
        $filtered = Arr::filter($this->toArray());

        return JSON::encode($filtered);
    }
}
