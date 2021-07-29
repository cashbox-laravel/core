<?php

declare(strict_types=1);

namespace Helldar\Cashier\Console\Commands;

use Helldar\Cashier\Exceptions\Logic\AlreadyRefundedException;
use Helldar\Cashier\Exceptions\Logic\PaymentInProgressException;
use Helldar\Cashier\Facades\Helpers\DriverManager;
use Helldar\Contracts\Cashier\Driver as DriverContract;
use Illuminate\Database\Eloquent\Model;

class Refund extends Base
{
    protected $signature = 'cashier:refund {payment_id}';

    protected $description = 'The command to call the cancellation of the payment with the return of funds to the sender';

    /**
     * @throws \Helldar\Cashier\Exceptions\Logic\AlreadyRefundedException
     * @throws \Helldar\Cashier\Exceptions\Logic\PaymentInProgressException
     */
    public function handle()
    {
        $payment = $this->payment();

        $driver = $this->driver($payment);

        $this->abort($driver, $payment);

        $driver->refund();
    }

    protected function payment(): Model
    {
        $model = $this->model();

        $id = $this->paymentId();

        return $model::query()->findOrFail($id);
    }

    protected function paymentId()
    {
        return $this->argument('payment_id');
    }

    /**
     * @param  \Helldar\Contracts\Cashier\Driver  $driver
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @throws \Helldar\Cashier\Exceptions\Logic\AlreadyRefundedException
     * @throws \Helldar\Cashier\Exceptions\Logic\PaymentInProgressException
     */
    protected function abort(DriverContract $driver, Model $model): void
    {
        $status = $driver->statuses();

        if ($status->inProgress()) {
            throw new PaymentInProgressException($model->getKey());
        }

        if ($status->hasRefunded()) {
            throw new AlreadyRefundedException($model->getKey());
        }
    }

    protected function driver(Model $model): DriverContract
    {
        return DriverManager::fromModel($model);
    }
}
