<?php

declare(strict_types=1);

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Facades\Helpers\HttpLog;
use Helldar\Contracts\Cashier\Resources\Model as ModelResource;
use Throwable;

trait Logs
{
    protected function logInfo(ModelResource $model, string $method, string $url, array $request, array $response, int $status_code, ?array $extra = []): void
    {
        HttpLog::info($model, $method, $url, $request, $response, $status_code, $extra);
    }

    protected function logError(ModelResource $model, string $method, string $url, array $request, Throwable $exception, ?array $extra = []): void
    {
        $this->logInfo($model, $method, $url, $request, [
            'Message' => $exception->getMessage(),
            'Trace'   => $exception->getTrace(),
        ], $exception->getCode(), $extra);
    }
}
