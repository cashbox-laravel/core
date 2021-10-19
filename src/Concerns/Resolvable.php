<?php

/*
 * This file is part of the "andrey-helldar/cashier-sber-qr" project.
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
 * @see https://github.com/andrey-helldar/cashier-sber-qr
 */

declare(strict_types=1);

namespace Helldar\Cashier\Concerns;

use Helldar\Support\Concerns\Resolvable as BaseResolvable;

trait Resolvable
{
    use BaseResolvable;

    protected $resolved_dynamic = [];

    protected function resolveDynamicCallback(string $value, callable $callback)
    {
        $class = static::getSameClass();

        if (isset($this->resolved_dynamic[$class][$value])) {
            return $this->resolved_dynamic[$class][$value];
        }

        return $this->resolved_dynamic[$class][$value] = $callback($value);
    }
}
