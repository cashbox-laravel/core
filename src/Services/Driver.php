<?php

namespace Helldar\Cashier\Services;

use Helldar\Cashier\Concerns\Resolvable;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Auth;
use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Contracts\Statuses;
use Helldar\Cashier\DTO\Request;
use Helldar\Cashier\DTO\Response;
use Helldar\Cashier\Facades\Config\Main;
use Helldar\Cashier\Facades\Helpers\Http;
use Helldar\Cashier\Requests\Payment;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\HttpBuilder;
use Illuminate\Database\Eloquent\Model;

abstract class Driver implements Contract
{
    use Makeable;
    use Resolvable;
    use Validators;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var \Helldar\Cashier\Requests\Payment */
    protected $request;

    /** @var \Helldar\Cashier\Contracts\Statuses|string */
    protected $statuses;

    /** @var \Helldar\Cashier\Contracts\Auth */
    protected $auth;

    /** @var string */
    protected $production_host;

    /** @var string */
    protected $dev_host;

    public function model(Model $model, string $request): Contract
    {
        $this->model = $model;

        $this->request = $this->resolveRequest($model, $request);

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

    protected function url(string $path): string
    {
        return HttpBuilder::parse($this->host())
            ->setPath($path)
            ->compile();
    }

    protected function request(Request $request): Response
    {
        return Http::post(
            $request->getUri(),
            $request->getData(),
            $request->getHeaders()
        );
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Helldar\Cashier\Requests\Payment|string  $request
     *
     * @return \Helldar\Cashier\Requests\Payment
     */
    protected function resolveRequest(Model $model, string $request): Payment
    {
        $this->validateRequest($request);

        return $request::make($model);
    }
}
