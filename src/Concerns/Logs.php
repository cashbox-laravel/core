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

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Facades\Helpers\HttpLog;
use DragonCode\Contracts\Cashier\Http\Request;
use DragonCode\Contracts\Cashier\Resources\Model as ModelResource;
use DragonCode\Contracts\Http\Builder;
use DragonCode\Support\Facades\Instances\Call;
use Throwable;

trait Logs
{
    protected function logInfo(ModelResource $model, string $method, Builder $url, array $request, array $response, int $status_code): void
    {
        HttpLog::info($model, $method, $url, $request, $response, $status_code, $model->getExtra());
    }

    protected function logError(ModelResource $model, Request $request, Throwable $exception): void
    {
        $this->logInfo($model, $request->method(), $request->uri(), $request->getRawBody(), [
            'Message' => $exception->getMessage(),
        ], $this->getStatusCode($exception));
    }

    protected function getStatusCode(Throwable $e): int
    {
        return (int) Call::runMethods($e, ['getStatusCode', 'getCode']) ?: 0;
    }
}
