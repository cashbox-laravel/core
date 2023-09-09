<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Exceptions;

use BackedEnum;
use Exception;

class BaseException extends Exception
{
    protected int $statusCode = 500;

    protected string $reason;

    public function __construct(object|string|null $haystack = null, int|string|null $needle = null)
    {
        parent::__construct($this->reason($haystack, $needle), $this->statusCode);
    }

    protected function reason(object|string|null $haystack, int|string|null $needle): string
    {
        if ($haystack = $this->haystack($haystack)) {
            return sprintf($this->reason, $haystack, $needle);
        }

        return $this->reason;
    }

    protected function haystack(object|string|null $haystack): ?string
    {
        if ($haystack instanceof BackedEnum) {
            return $haystack->value ?? $haystack->name;
        }

        return is_object($haystack) ? get_class($haystack) : $haystack;
    }
}
