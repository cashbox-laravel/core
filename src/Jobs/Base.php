<?php

namespace Helldar\Cashier\Jobs;

use Carbon\Carbon;
use Helldar\Cashier\Contracts\Driver;
use Helldar\Cashier\Facade\Config\Check as CheckConfig;
use Helldar\Cashier\Facade\Helpers\Driver as DriverHelper;
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

    public $model;

    public $force_break;

    public function __construct(Model $model, bool $force_break = false)
    {
        $this->model = $model;

        $this->force_break = $force_break;
    }

    abstract public function handle();

    public function retryUntil(): Carbon
    {
        $timeout = CheckConfig::timeout();

        return Carbon::now()->addSeconds($timeout);
    }

    protected function driver(): Driver
    {
        return DriverHelper::fromModel($this->model);
    }

    protected function hasBreak(): bool
    {
        return $this->force_break;
    }
}
