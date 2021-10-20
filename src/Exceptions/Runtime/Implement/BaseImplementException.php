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

namespace CashierProvider\Manager\Exceptions\Runtime\Implement;

use CashierProvider\Manager\Exceptions\Runtime\BaseException;

/** @method BaseImplementException __construct(string $class) */
abstract class BaseImplementException extends BaseException
{
    protected $reason = 'The %s class must implement %s';

    protected $needle;

    public function getReason(...$values): string
    {
        return parent::getReason($values[0], $this->needle);
    }
}
