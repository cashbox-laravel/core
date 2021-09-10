<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Facades\Config\Details;
use Helldar\Cashier\Models\CashierDetailsLog;
use Helldar\Contracts\Cashier\Resources\Model as ModelResource;

class HttpLog
{
    public function info(ModelResource $model, string $method, string $url, array $request, array $response, int $status_code): void
    {
        if ($this->has()) {
            $this->store($model, $method, $url, $request, $response, $status_code);
        }
    }

    protected function store(ModelResource $model, string $method, string $url, array $request, array $response, int $status_code): void
    {
        CashierDetailsLog::create([
            'payment_id'  => $model->getPaymentId(),
            'external_id' => $model->getExternalId(),

            'sum'      => $model->getSum(),
            'currency' => $model->getCurrency(),

            'method'      => $method,
            'url'         => $url,
            'status_code' => $status_code,

            'request'  => $request,
            'response' => $response,
        ]);
    }

    protected function has(): bool
    {
        return Details::hasLogsEnabled();
    }
}
