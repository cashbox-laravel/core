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

/** @method UnknownCurrencyCodeException __construct(string $currency) */
class UnknownCurrencyCodeException extends BaseException
{
    protected string $reason = 'Unknown currency code: "%s".';
}
