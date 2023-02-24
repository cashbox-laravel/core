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

use CashierProvider\Core\Facades\HttpLog;
use CashierProvider\Core\Http\Request;
use CashierProvider\Core\Resources\Model;
use DragonCode\Support\Facades\Instances\Call;
use DragonCode\Support\Http\Builder;
use Throwable;

trait Logs
{
    protected function logInfo(Model $model, string $method, Builder $url, array $request, array $response, int $status_code): void
    {
        HttpLog::info($model, $method, $url, $request, $response, $status_code, $model->getExtra());
    }

    protected function logError(Model $model, Request $request, Throwable $exception): void
    {
        $this->logInfo($model, $request->method(), $request->uri(), $request->getRawBody(), [
            'Message' => $exception->getMessage(),
        ], $this->getStatusCode($exception));
    }

    protected function getStatusCode(Throwable $e): int
    {
        return (int) Call::runMethods($e, ['getStatusCode', 'getCode']);
    }
}
