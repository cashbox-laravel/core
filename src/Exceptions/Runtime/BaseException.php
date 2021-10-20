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

namespace CashierProvider\Core\Exceptions\Runtime;

use CashierProvider\Core\Concerns\Exceptionable;
use Helldar\Contracts\Exceptions\RuntimeException;

abstract class BaseException extends \RuntimeException implements RuntimeException
{
    use Exceptionable;

    public function __construct(...$values)
    {
        $message = $this->getReason(...$values);

        parent::__construct($message, $this->getStatus());
    }
}
