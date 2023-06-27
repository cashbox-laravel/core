<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Exceptions\Runtime\Implement;

use CashierProvider\Core\Exceptions\Runtime\BaseException;

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
