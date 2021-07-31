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

namespace Helldar\Cashier\Concerns;

/**
 * @property int $default_status_code
 */
trait Exceptionable
{
    protected $status_code;

    protected $reason;

    public function getStatus(): int
    {
        return $this->status_code ?: $this->getDefaultStatusCode();
    }

    public function getReason(...$values): string
    {
        return sprintf($this->reason, ...$values);
    }

    protected function getDefaultStatusCode(): int
    {
        return $this->default_status_code ?? 500;
    }
}
