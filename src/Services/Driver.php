<?php

namespace Helldar\Cashier\Services;

use Helldar\Cashier\Concerns\Resolvable;
use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Auth;
use Helldar\Cashier\Contracts\Driver as Contract;
use Helldar\Cashier\Contracts\Statuses;
use Helldar\Cashier\Facade\Config\Main;
use Helldar\Cashier\Requests\Payment;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

abstract class Driver implements Contract
{
    use Makeable;
    use Resolvable;
    use Validators;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var \Helldar\Cashier\Requests\Payment */
    protected $map;

    /** @var \Helldar\Cashier\Contracts\Statuses|string */
    protected $statuses;

    /** @var \Helldar\Cashier\Contracts\Auth */
    protected $auth;

    /** @var string */
    protected $production_host;

    /** @var string */
    protected $dev_host;

    public function model(Model $model, string $map): Contract
    {
        $this->model = $model;

        $this->map = $this->makeMap($model, $map);

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

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Helldar\Cashier\Requests\Payment|string  $map
     *
     * @return \Helldar\Cashier\Requests\Payment
     */
    protected function makeMap(Model $model, string $map): Payment
    {
        $this->validateRequest($map);

        return $map::make($model);
    }
}
