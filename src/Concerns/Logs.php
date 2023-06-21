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

use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Http\Request;
use CashierProvider\Core\Resources\Model;
use DragonCode\Support\Facades\Instances\Call;
use DragonCode\Support\Http\Builder;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Throwable;

trait Logs
{
    protected function logInfo(
        Model $model,
        string $method,
        Builder $url,
        array $request,
        array $response,
        int $status,
        string $level = LogLevel::INFO
    ): void {
        if ($this->enabledLogs()) {
            $this->logsChannel()->log($level, "$method $url", [
                'external_id' => $model->getExternalId(),

                'status_code' => $status,

                'request'  => $request,
                'response' => $response,
            ]);
        }
    }

    protected function logError(Model $model, Request $request, Throwable $exception): void
    {
        $this->logInfo($model, $request->method(), $request->uri(), $request->getRawBody(), [
            'Message' => $exception->getMessage(),
        ], $this->getStatusCode($exception), LogLevel::ERROR);
    }

    protected function getStatusCode(Throwable $e): int
    {
        return (int) Call::runMethods($e, ['getStatusCode', 'getCode']);
    }

    protected function enabledLogs(): bool
    {
        return Config::logs()->enabled;
    }

    protected function logsChannel(): LoggerInterface
    {
        return Config::logs()->channel;
    }
}
