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
 * @property int $default_status_code
 */
trait Exceptionable
{
    protected int $status_code;

    protected string $reason;

    public function getStatus(): int
    {
        return $this->status_code ?: $this->getDefaultStatusCode();
    }

    public function getReason(string|int|float ...$values): string
    {
        return sprintf($this->reason, ...$values);
    }

    protected function getDefaultStatusCode(): int
    {
        return $this->default_status_code ?? 500;
    }
}
