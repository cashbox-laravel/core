<?php

namespace Helldar\Cashier\Console\Commands;

use Helldar\Cashier\Exceptions\AlreadyRefundedException;
use Helldar\Cashier\Exceptions\PaymentInProgressException;
use Helldar\Cashier\Facades\Helpers\Driver;
use Illuminate\Database\Eloquent\Model;

class Refund extends Base
{
    protected $signature = 'cashier:refund {payment_id}';

    protected $description = 'The command to call the cancellation of the payment with the return of funds to the sender';

    public function handle()
    {
        $payment = $this->payment();

        $driver = $this->driver($payment);

        $this->abort($driver, $payment);

        $this->refund($driver);
    }

    protected function refund(\Helldar\Cashier\Contracts\Driver $driver)
    {
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

    protected function abort(\Helldar\Cashier\Contracts\Driver $driver, Model $model): void
    {
        $status = $driver->statuses();

        if ($status->inProgress()) {
            throw new PaymentInProgressException($model->getKey());
        }

        if ($status->hasRefunded()) {
            throw new AlreadyRefundedException($model->getKey());
        }
    }

    protected function driver(Model $model): \Helldar\Cashier\Contracts\Driver
    {
        return Driver::fromModel($model);
    }
}
