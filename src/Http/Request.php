<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Http;

use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Facades\Config\Main;
use Helldar\Contracts\Cashier\Auth\Auth;
use Helldar\Contracts\Cashier\Http\Request as Contract;
use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\Contracts\Http\Builder as HttpBuilderContract;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Http\Builder as HttpBuilder;

/**
 * @method static Contract make(Model $model)
 */
abstract class Request implements Contract
{
    use Makeable;
    use Validators;

    /** @var \Helldar\Contracts\Cashier\Resources\Model */
    protected $model;

    /** @var string */
    protected $production_host;

    /** @var string */
    protected $dev_host;

    /** @var string|null */
    protected $path;

    /** @var \Helldar\Contracts\Cashier\Auth\Auth|null */
    protected $auth;

    /** @var array */
    protected $auth_extra = [];

    /** @var bool */
    protected $hash = true;

    public function __construct(Model $model)
    {
        $this->model = $model;

        $this->auth = $this->resolveAuth($model);
    }

    public function uri(): HttpBuilderContract
    {
        $host = $this->getHost();

        return HttpBuilder::parse($host)->withPath($this->path);
    }

    public function headers(): array
    {
        return $this->auth ? $this->auth->headers() : $this->getRawHeaders();
    }

    public function body(): array
    {
        return $this->auth ? $this->auth->body() : $this->getRawBody();
    }

    public function getHttpOptions(): array
    {
        return [];
    }

    public function refreshAuth(): void
    {
        if (empty($this->auth)) {
            return;
        }

        $this->auth->refresh();
    }

    protected function getHost(): string
    {
        return ! Main::isProduction() && $this->dev_host
            ? $this->dev_host
            : $this->production_host;
    }

    /**
     * @param  \Helldar\Contracts\Cashier\Resources\Model  $model
     *
     * @return \Helldar\Contracts\Cashier\Auth\Auth|null
     */
    protected function resolveAuth(Model $model): ?Auth
    {
        if (empty($this->auth)) {
            return null;
        }

        $auth = $this->auth;

        return $auth::make($model, $this, $this->hash, $this->auth_extra);
    }
}
