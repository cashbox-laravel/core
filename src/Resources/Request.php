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

namespace Helldar\Cashier\Resources;

use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Facades\Config\Main;
use Helldar\Contracts\Cashier\Auth\Auth;
use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\Contracts\Cashier\Resources\Request as Contract;
use Helldar\Contracts\Http\Builder as HttpBuilderContract;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Http\Builder as HttpBuilder;

/**
 * @method static Contract make(Model $model, string $auth = null, bool $hash_token = true)
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

    /** @var bool */
    protected $hash_token;

    public function __construct(Model $model, string $auth = null, bool $hash_token = true)
    {
        $this->model = $model;
        $this->auth  = $auth;

        $this->hash_token = $hash_token;
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

    protected function getHost(): string
    {
        return ! Main::isProduction() && $this->dev_host
            ? $this->dev_host
            : $this->production_host;
    }

    protected function resolveAuth(): ?Auth
    {
        if (! is_string($this->auth)) {
            return $this->auth;
        }

        $auth = $this->auth;

        return $this->auth = $auth::make($this->model, $this, $this->hash_token);
    }
}
