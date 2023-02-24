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

namespace CashierProvider\Core\Exceptions\Runtime\Implement;

use CashierProvider\Core\Exceptions\Runtime\BaseException;

/** @method BaseImplementException __construct(string $class) */
abstract class BaseImplementException extends BaseException
{
    protected string $reason = 'The %s class must implement %s';

    protected string|int|float $needle;

    public function getReason(...$values): string
    {
        return parent::getReason($values[0], $this->needle);
    }
}
