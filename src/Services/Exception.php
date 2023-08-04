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

namespace Cashbox\Core\Services;

use Cashbox\Core\Exceptions\External\BadRequestClientException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

abstract class Exception
{
    protected array $codes = [];

    /**
     * Can be:
     *   ['Success'] // also as ['Success' => false]
     *   ['Success' => false]
     *   ['Success' => 0]
     *   ['Status' => 'error']
     *
     * @var array
     */
    protected array $failedKey = [];

    protected array $codeKeys = ['StatusCode', 'Code'];

    protected array $reasonKeys = ['Message', 'Data'];

    protected string $default = BadRequestClientException::class;

    public function throwIf(Response $response): void
    {
        if ($response->failed() || $this->hasFailed($response->json())) {
            $this->throw((string) $response->effectiveUri(), $response->status(), $response->json());
        }
    }

    public function throw(string $uri, int $statusCode, array $content): void
    {
        $code      = $this->getCode($statusCode, $content);
        $exception = $this->getException($code);
        $reason    = $this->getReason($content);

        throw new $exception($uri, $reason);
    }

    protected function hasFailed(array $data): bool
    {
        foreach ($this->failedKey as $k => $v) {
            $key   = is_numeric($k) ? $v : $k;
            $value = is_numeric($k) ? false : $v;

            if (Arr::get($data, $key) == $value) {
                return true;
            }
        }

        return false;
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
