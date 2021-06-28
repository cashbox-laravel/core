<?php

namespace Helldar\Cashier\Console\Commands;

use Carbon\Carbon;
use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Facade\Config\Payment;
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
            ->where($this->attributeStatus(), Status::NEW)
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
        $this->job()->check($model, true);
    }

    protected function job(): Jobs
    {
        return new Jobs();
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

    protected function before(): Carbon
    {
        return Carbon::now()->subHour();
    }
}
