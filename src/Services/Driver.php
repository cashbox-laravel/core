<?php

declare(strict_types=1);

namespace Helldar\Cashier\Services;

use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\DTO\Request;
use Helldar\Cashier\Facades\Config\Main;
use Helldar\Cashier\Facades\Helpers\Http;
use Helldar\Contracts\Cashier\Driver as Contract;
use Helldar\Contracts\Cashier\DTO\Config;
use Helldar\Contracts\Cashier\Exceptions\ExceptionManager;
use Helldar\Contracts\Cashier\Helpers\Statuses;
use Helldar\Contracts\Cashier\Resources\Request as RequestContract;
use Helldar\Contracts\Cashier\Resources\Response;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Concerns\Resolvable;
use Helldar\Support\Facades\Http\Builder;
use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\UriInterface;

abstract class Driver implements Contract
{
    use Makeable;
    use Resolvable;
    use Validators;

    /** @var \Helldar\Contracts\Cashier\DTO\Config */
    protected $config;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var \Helldar\Contracts\Cashier\Resources\Request */
    protected $request;

    /** @var \Helldar\Cashier\Resources\Response|string */
    protected $response;

    /** @var \Helldar\Contracts\Cashier\Helpers\Statuses|string */
    protected $statuses;

    /** @var \Helldar\Cashier\Helpers\ExceptionManager|string */
    protected $exception;

    /** @var string */
    protected $production_host;

    /** @var string */
    protected $dev_host;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function response(array $data, bool $mapping = true): Response
    {
        $instance = $this->response;

        $this->validateResponse($instance);

        return $instance::make($data, $mapping);
    }

    public function model(Model $model): Contract
    {
        $this->model = $model;

        $this->request = $this->requestResource($model, $this->config->getRequest());

        return $this;
    }

    public function statuses(): Statuses
    {
        return static::resolveCallback($this->statuses, function ($statuses) {
            /* @var \Helldar\Cashier\Helpers\Statuses|string $statuses */

            $this->validateStatuses($statuses);

            return $statuses::make()->model($this->model);
        });
    }

    public function exception(): ExceptionManager
    {
        return static::resolveInstance($this->exception);
    }

    public function host(): string
    {
        return Main::hasProduction() ? $this->production_host : $this->dev_host;
    }

    abstract protected function headers(array $headers, bool $hash = true): array;

    abstract protected function content(array $content, bool $hash = true): array;

    protected function url(string $path): UriInterface
    {
        return Builder::parse($this->host())->withPath($path);
    }

    protected function request(Request $request, bool $store_details = true): Response
    {
        $response = Http::post(
            $request->getUri(),
            $request->getData(),
            $request->getHeaders()
        );

        $details = $this->response($response);

        if ($store_details) {
            $this->storeDetails($details);
        }

        return $details;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Helldar\Cashier\Resources\Request|string  $request
     *
     * @return \Helldar\Cashier\Resources\Request
     */
    protected function requestResource(Model $model, string $request): RequestContract
    {
        $this->validateResource($request);

        return $request::make($model, $this->config);
    }

    protected function storeDetails(Response $details): void
    {
        $payment_id = $details->getPaymentId();

        $this->model->cashier()->updateOrCreate(compact('payment_id'), compact('details'));
    }
}
