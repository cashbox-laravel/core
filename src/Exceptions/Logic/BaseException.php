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

namespace CashierProvider\Core\Exceptions\Logic;

use CashierProvider\Core\Concerns\Exceptionable;
use DragonCode\Contracts\Exceptions\LogicException;
use Exception;

abstract class BaseException extends Exception implements LogicException
{
    use Exceptionable;

    public $default_status_code = 400;

    /**
     * @param  int|string  $payment_id
     */
    public function __construct($payment_id)
    {
        $message = $this->getReason($payment_id);

        parent::__construct($message, $this->getStatus());
    }
}
