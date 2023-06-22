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

namespace CashierProvider\Core\Exceptions\Http;

use CashierProvider\Core\Concerns\Exceptionable;
use DragonCode\Support\Http\Builder;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseException extends HttpException
{
    use Exceptionable;

    public int $defaultStatusCode = 400;

    public function __construct(Builder $uri, ?string $reason = null)
    {
        $message = $this->message($uri, $reason);

        $code = $this->getStatus();

        parent::__construct($code, $message, null, [], $code);
    }

    protected function message(Builder $uri, ?string $reason): string
    {
        $reason = $reason ?: $this->getReason();

        return $uri->toUrl() . ': ' . $reason;
    }
}
