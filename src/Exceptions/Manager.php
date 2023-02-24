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

namespace CashierProvider\Core\Exceptions;

use CashierProvider\Core\Concerns\FailedEvent;
use CashierProvider\Core\Exceptions\Http\BadRequestClientException;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Http\Builder;

abstract class Manager
{
    use FailedEvent;

    protected array $codes = [];

    protected string $default = BadRequestClientException::class;

    protected array $code_keys = ['StatusCode', 'Code'];

    protected array $reason_keys = ['Message', 'Data'];

    protected array $success_keys = ['Success'];

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
        $code = $this->getCode($code, $response);

        $exception = $this->getException($code);

        $reason = $this->getReason($response);

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
        foreach ($this->code_keys as $key) {
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
        foreach ($this->reason_keys as $key) {
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
        foreach ($this->success_keys as $key) {
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
