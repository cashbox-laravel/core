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

use DragonCode\Support\Concerns\Resolvable as BaseResolvable;

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
