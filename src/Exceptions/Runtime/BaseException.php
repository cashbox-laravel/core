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

namespace CashierProvider\Core\Exceptions\Runtime;

use CashierProvider\Core\Concerns\Exceptionable;
use DragonCode\Contracts\Exceptions\RuntimeException;

abstract class BaseException extends \RuntimeException implements RuntimeException
{
    use Exceptionable;

    public function __construct(...$values)
    {
        $message = $this->getReason(...$values);

        parent::__construct($message, $this->getStatus());
    }
}
