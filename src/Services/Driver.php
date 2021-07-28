<?php

declare(strict_types=1);

namespace Helldar\Cashier\Services;

use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Facades\Helpers\Http;
use Helldar\Contracts\Cashier\Config\Driver as DriverConfig;
use Helldar\Contracts\Cashier\Driver as Contract;
use Helldar\Contracts\Cashier\Exceptions\ExceptionManager;
use Helldar\Contracts\Cashier\Helpers\Statuses;
use Helldar\Contracts\Cashier\Resources\Model as ModelResource;
use Helldar\Contracts\Cashier\Resources\Request as RequestResource;
use Helldar\Contracts\Cashier\Resources\Response;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Concerns\Resolvable;
use Illuminate\Database\Eloquent\Model;

abstract class Driver implements Contract
{
    use Makeable;
    use Resolvable;
    use Validators;

    /** @var DriverConfig */
    protected $config;

    /** @var Model */
    protected $payment;

    /** @var ModelResource */
    protected $model;

    /** @var ExceptionManager */
    protected $exceptions;

    /** @var \Helldar\Contracts\Cashier\Helpers\Statuses|string */
    protected $statuses;

    public function __construct(DriverConfig $config, Model $payment)
    {
        $this->config = $config;

        $this->payment = $this->validateModel($payment);

        $this->model = $this->resolveModel($payment);
    }

    public function statuses(): Statuses
    {
        return self::resolveCallback($this->statuses, function (string $statuses) {
            /* @var \Helldar\Contracts\Cashier\Helpers\Statuses|string $statuses */

            return $statuses::make($this->payment);
        });
    }

    /**
     * @param  \Helldar\Contracts\Cashier\Resources\Request  $request
     * @param  \Helldar\Contracts\Cashier\Resources\Response|string  $response
     *
     * @return \Helldar\Contracts\Cashier\Resources\Response
     */
    protected function request(RequestResource $request, string $response): Response
    {
        $manager = $this->resolveExceptionManager();

        $content = Http::post($request, $manager);

        return $response::make($content);
    }

    protected function resolveModel(Model $payment): ModelResource
    {
        $resource = $this->config->getResource();

        return $resource::make($payment);
    }

    protected function resolveExceptionManager(): ExceptionManager
    {
        return self::resolveInstance($this->exceptions);
    }
}
