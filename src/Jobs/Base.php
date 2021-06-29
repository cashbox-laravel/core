<?php

namespace Helldar\Cashier\Jobs;

use Carbon\Carbon;
use Helldar\Cashier\Contracts\Driver;
use Helldar\Cashier\Facades\Config\Check as CheckConfig;
use Helldar\Cashier\Facades\Config\Payment;
use Helldar\Cashier\Facades\Helpers\Driver as DriverHelper;
use Helldar\Cashier\Resources\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Base implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var \Illuminate\Database\Eloquent\Model|\Helldar\Cashier\Concerns\Casheable */
    public $model;

    public $force_break;

    /** @var \Helldar\Cashier\Contracts\Driver */
    protected $driver;

    public function __construct(Model $model, bool $force_break = false)
    {
        $this->model = $model;

        $this->force_break = $force_break;
    }

    abstract public function handle();

    abstract protected function process(): Response;

    public function retryUntil(): Carbon
    {
        $timeout = CheckConfig::timeout();

        return Carbon::now()->addSeconds($timeout);
    }

    protected function driver(): Driver
    {
        if (! empty($this->driver)) {
            return $this->driver;
        }

        return $this->driver = DriverHelper::fromModel($this->model);
    }

    protected function hasBreak(): bool
    {
        return $this->force_break;
    }

    protected function store(Response $details): void
    {
        $builder = $this->model->cashier();

        $builder->doesntExist()
            ? $builder->create(compact('details'))
            : $builder->update(compact('details'));
    }

    protected function modelId(): string
    {
        return $this->model->getKey();
    }

    protected function returnToQueue(): void
    {
        $delay = CheckConfig::delay();

        $this->release($delay);
    }

    protected function updateParentStatus(string $status): void
    {
        $attribute = $this->attributeStatus();
        $status    = $this->status($status);

        $this->model->update([
            $attribute => $status,
        ]);
    }

    protected function attributeStatus(): string
    {
        return Payment::attributeStatus();
    }

    protected function status(string $status)
    {
        return Payment::status($status);
    }

    protected function hasSuccess(string $status): bool
    {
        return $this->driver()->statuses()->hasSuccess($status);
    }

    protected function hasFailed(string $status): bool
    {
        return $this->driver()->statuses()->hasFailed($status);
    }

    protected function hasRefunding(string $status): bool
    {
        return $this->driver()->statuses()->hasRefunding($status);
    }

    protected function hasRefunded(string $status): bool
    {
        return $this->driver()->statuses()->hasRefunded($status);
    }
}
