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

/**
 * @property int $defaultStatusCode
 */
trait Exceptionable
{
    protected int $statusCode;

    protected string $reason;

    public function getStatus(): int
    {
        return $this->statusCode ?: $this->getDefaultStatusCode();
    }

    public function getReason(mixed ...$values): string
    {
        return sprintf($this->reason, ...$values);
    }

    protected function getDefaultStatusCode(): int
    {
        return $this->defaultStatusCode ?? 500;
    }
}
