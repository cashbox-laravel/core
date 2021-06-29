<?php

namespace Helldar\Cashier\Console\Commands;

use Carbon\Carbon;
use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Services\Jobs;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Check extends Command
{
    protected $signature = 'cashier:check';

    protected $description = 'Launching a re-verification of payments with a long processing cycle';

    protected $count = 1000;

    public function handle()
    {
        $this->payments()->chunk($this->count, function (Collection $payments) {
            $payments->each(function (Model $payment) {
                $this->check($payment);
            });
        });
    }

    protected function payments(): Builder
    {
        $model = $this->model();

        return $model::query()
            ->whereIn($this->attributeType(), $this->attributeTypes())
            ->where($this->attributeStatus(), $this->getStatus())
            ->where('created_at', '<', $this->before());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|string
     */
    protected function model(): string
    {
        return Payment::model();
    }

    protected function check(Model $model)
    {
        Jobs::make($model)->check(true);
    }

    protected function attributeType(): string
    {
        return Payment::attributeType();
    }

    protected function attributeTypes(): array
    {
        $assigned = Payment::assignDrivers();

        return array_keys($assigned);
    }

    protected function attributeStatus(): string
    {
        return Payment::attributeStatus();
    }

    protected function getStatus()
    {
        return Payment::status(Status::NEW);
    }

    protected function before(): Carbon
    {
        return Carbon::now()->subHour();
    }
}
