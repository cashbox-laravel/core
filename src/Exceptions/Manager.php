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

namespace CashierProvider\Core\Exceptions;

use CashierProvider\Core\Concerns\Events;
use CashierProvider\Core\Exceptions\Http\BadRequestClientException;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Http\Builder;

use function array_key_exists;
use function is_null;
use function is_string;

class Manager
{
    use Events;

    protected array $codes = [];

    protected string $default = BadRequestClientException::class;

    protected array $codeKeys = ['StatusCode', 'Code'];

    protected array $reasonKeys = ['Message', 'Data'];

    protected array $successKeys = ['Success'];

    public function validateResponse(Builder $uri, array $response, int $status_code): void
    {
        if (
            $this->isFailedCode($status_code)
            || $this->isFailedContentCode($response)
            || $this->isFailedContent($response)
        ) {
            $this->throw($uri, $status_code, $response);
        }
    }

    public function throw(Builder $uri, int $code, array $response): void
    {
        $code      = $this->getCode($code, $response);
        $exception = $this->getException($code);
        $reason    = $this->getReason($response);

        $e = new $exception($uri, $reason);

        $this->failedEvent($e);

        throw $e;
    }

    protected function getCode(int $code, array $response): int
    {
        return $this->getCodeByResponseContent($response) ?: $code;
    }

    protected function getCodeByResponseContent(array $response): ?int
    {
        foreach ($this->codeKeys as $key) {
            if ($code = Arr::get($response, $key)) {
                return (int) $code;
            }
        }

        return null;
    }

    protected function getException(int $code): string
    {
        return Arr::get($this->codes, $code, $this->default);
    }

    protected function getReason(array $response): ?string
    {
        foreach ($this->reasonKeys as $key) {
            if ($value = Arr::get($response, $key)) {
                if (is_string($value) && ! empty($value)) {
                    return $value;
                }
            }
        }

        return null;
    }

    protected function isFailedCode(int $code): bool
    {
        return $code < 200 || $code >= 400;
    }

    protected function isFailedContent(array $response): bool
    {
        foreach ($this->successKeys as $key) {
            if (Arr::exists($response, $key)) {
                $value = Arr::get($response, $key);

                return $value !== true;
            }
        }

        return false;
    }

    protected function isFailedContentCode(array $response): bool
    {
        $code = $this->getCodeByResponseContent($response);

        return ! is_null($code) && array_key_exists($code, $this->codes);
    }
}
