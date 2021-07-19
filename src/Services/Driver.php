<?php

namespace Helldar\Cashier\Services;

use Helldar\Cashier\Concerns\Resolvable;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Auth;
use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Contracts\Payment;
use Helldar\Cashier\Contracts\Statuses;
use Helldar\Cashier\DTO\Request;
use Helldar\Cashier\Facades\Config\Main;
use Helldar\Cashier\Facades\Helpers\Http;
use Helldar\Cashier\Resources\Response;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Http\Builder;
use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\UriInterface;

abstract class Driver implements Contract
{
    use Makeable;
    use Resolvable;
    use Validators;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var \Helldar\Cashier\Resources\Request */
    protected $resource;

    /** @var \Helldar\Cashier\Resources\Response|string */
    protected $response;

    /** @var \Helldar\Cashier\Contracts\Statuses|string */
    protected $statuses;

    /** @var \Helldar\Cashier\Contracts\Auth */
    protected $auth;

    /** @var string */
    protected $production_host;

    /** @var string */
    protected $dev_host;

    public function response(array $data): Response
    {
        $instance = $this->response;

        $this->validateResponse($instance);

        return $instance::make($data);
    }

    public function model(Model $model, string $request): Contract
    {
        $this->model = $model;

        $this->resource = $this->resource($model, $request);

        return $this;
    }

    public function auth(Auth $auth): Contract
    {
        $this->auth = $auth;

        return $this;
    }

    public function statuses(): Statuses
    {
        return $this->resolve($this->statuses, function ($statuses) {
            /** @var \Helldar\Cashier\Helpers\Statuses|string $statuses */

            $this->validateStatuses($statuses);

            return $statuses::make()->model($this->model);
        });
    }

    public function host(): string
    {
        return Main::hasProduction() ? $this->production_host : $this->dev_host;
    }

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
     * @param  \Helldar\Cashier\Resources\Request|string  $resource
     *
     * @return \Helldar\Cashier\Resources\Request
     */
    protected function resource(Model $model, string $resource): Payment
    {
        $this->validateResource($resource);

        return $resource::make($model);
    }

    protected function storeDetails(Response $details): void
    {
        $payment_id = $details->paymentId();

        $this->model->cashier()->updateOrCreate(compact('payment_id'), compact('details'));
    }
}
