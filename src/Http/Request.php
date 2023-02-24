<?php

/*
 * This file is part of the "cashier-provider/core" project.
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
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Http;

use CashierProvider\Core\Concerns\Validators;
use CashierProvider\Core\Facades\Config\Main;
use CashierProvider\Core\Support\URI;
use DragonCode\Contracts\Cashier\Auth\Auth;
use DragonCode\Contracts\Cashier\Http\Request as Contract;
use DragonCode\Contracts\Http\Builder as HttpBuilderContract;
use DragonCode\Support\Concerns\Makeable;
use Fig\Http\Message\RequestMethodInterface;

/**
 * @method static Contract make(\CashierProvider\Core\Resources\Model $model)
 */
abstract class Request implements Contract
{
    use Makeable;
    use Validators;

    protected \CashierProvider\Core\Resources\Model $model;

    /** @var string HTTP Request method */
    protected string $method = RequestMethodInterface::METHOD_POST;

    /** @var string */
    protected string $production_host;

    /** @var string */
    protected string $dev_host;

    /** @var string|null */
    protected ?string $path;

    /** @var \DragonCode\Contracts\Cashier\Auth\Auth|null */
    protected ?Auth $auth;

    /** @var array */
    protected array $auth_extra = [];

    /** @var bool */
    protected bool $hash = true;

    /** @var bool */
    protected bool $reload_relations = false;

    public function __construct(\CashierProvider\Core\Resources\Model $model)
    {
        $this->model = $this->reloadRelations($model);
        $this->auth  = $this->resolveAuth($model);
    }

    public function model(): \CashierProvider\Core\Resources\Model
    {
        return $this->model;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): HttpBuilderContract
    {
        return $this->getUriBuilder()->getWithPath($this->getPath());
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

    protected function reloadRelations(\CashierProvider\Core\Resources\Model $model): \CashierProvider\Core\Resources\Model
    {
        if ($this->reload_relations) {
            $model->getPaymentModel()->refresh();
        }

        return $model;
    }

    protected function getUriBuilder(): URI
    {
        return URI::make($this->production_host, $this->dev_host, Main::isProduction());
    }

    protected function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param \CashierProvider\Core\Resources\Model $model
     *
     * @return \DragonCode\Contracts\Cashier\Auth\Auth|null
     */
    protected function resolveAuth(\CashierProvider\Core\Resources\Model $model): ?Auth
    {
        if (empty($this->auth)) {
            return null;
        }

        $auth = $this->auth;

        return $auth::make($model, $this, $this->hash, $this->auth_extra);
    }
}
