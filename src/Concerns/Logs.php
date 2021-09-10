<?php

declare(strict_types=1);

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Facades\Helpers\HttpLog;
use Helldar\Contracts\Cashier\Resources\Model as ModelResource;
use Throwable;

trait Logs
{
    protected function logInfo(ModelResource $model, string $method, string $url, array $request, array $response, int $status_code): void
    {
        HttpLog::info($model, $method, $url, $request, $response, $status_code);
    }

    protected function logError(ModelResource $model, string $method, string $url, array $request, Throwable $exception): void
    {
        HttpLog::info($model, $method, $url, $request, [
            'Message' => $exception->getMessage(),
            'Trace'   => $exception->getTrace(),
        ], $exception->getCode());
    }
}
