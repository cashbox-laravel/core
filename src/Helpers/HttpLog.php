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

namespace CashierProvider\Core\Helpers;

use CashierProvider\Core\Facades\Config\Logs;
use DragonCode\Contracts\Cashier\Resources\Model as ModelResource;
use DragonCode\Contracts\Http\Builder;

class HttpLog
{
    public function info(ModelResource $model, string $method, Builder $url, array $request, array $response, int $status_code, ?array $extra = []): void
    {
        if ($this->enabled()) {
            $this->store($model, $method, $url->toUrl(), $request, $response, $status_code, $extra);
        }
    }

    protected function store(ModelResource $model, string $method, string $url, array $request, array $response, int $status_code, ?array $extra = []): void
    {
        $model->getPaymentModel()->cashierLogs()->create([
            'external_id' => $model->getExternalId(),

            'method'      => $method,
            'url'         => $url,
            'status_code' => $status_code,

            'request'  => $request,
            'response' => $response,
            'extra'    => $extra,
        ]);
    }

    protected function enabled(): bool
    {
        return Logs::isEnabled();
    }
}
