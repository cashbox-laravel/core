<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Exceptions\External\BadRequestClientException;

abstract class Exception
{
    protected array $codes = [];

    protected array $codeKeys = ['StatusCode', 'Code'];

    protected array $reasonKeys = ['Message', 'Data'];

    protected string $default = BadRequestClientException::class;

    public function throw(string $uri, int $statusCode, array $content): void
    {
        $code      = $this->getCode($statusCode, $content);
        $exception = $this->getException($code);
        $reason    = $this->getReason($content);

        throw new $exception($uri, $reason);
    }

    protected function getCode(int $statusCode, array $content): int
    {
        foreach ($this->codeKeys as $key) {
            if ($code = $content[$key] ?? null) {
                return (int) $code;
            }
        }

        return $statusCode;
    }

    protected function getException(int $statusCode): string
    {
        return $this->codes[$statusCode] ?? $this->default;
    }

    protected function getReason(array $content): string
    {
        foreach ($this->reasonKeys as $key) {
            if ($reason = $content[$key] ?? null) {
                if (is_string($reason) && ! empty($reason)) {
                    return $reason;
                }
            }
        }

        return __('Bad Request');
    }
}
