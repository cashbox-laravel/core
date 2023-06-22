<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Http;

use CashierProvider\Core\Concerns\Validators;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Resources\Model;
use CashierProvider\Core\Support\URI;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Http\Builder;
use Fig\Http\Message\RequestMethodInterface;

/**
 * @method static Request make(Model $model)
 */
abstract class Request
{
    use Makeable;
    use Validators;

    /** @var string HTTP Request method */
    protected string $method = RequestMethodInterface::METHOD_POST;

    protected string $productionHost;

    protected string $devHost;

    protected ?string $path;

    protected ?Auth $auth;

    protected array $authExtra = [];

    protected bool $hash = true;

    protected bool $reloadRelations = false;

    abstract public function getRawBody(): array;

    abstract public function getRawHeaders(): array;

    public function __construct(
        protected Model $model
    ) {
        $this->reloadRelations($this->model);

        $this->auth = $this->resolveAuth($this->model);
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): Builder
    {
        return $this->getUriBuilder()->getWithPath($this->getPath());
    }

    public function headers(): array
    {
        return $this->auth?->headers() ?? $this->getRawHeaders();
    }

    public function body(): array
    {
        return $this->auth?->body() ?? $this->getRawBody();
    }

    public function getHttpOptions(): array
    {
        return [];
    }

    public function refreshAuth(): void
    {
        $this->auth?->refresh();
    }

    protected function reloadRelations(Model $model): void
    {
        if ($this->reloadRelations) {
            $model->getPaymentModel()->refresh();
        }
    }

    protected function getUriBuilder(): URI
    {
        return URI::make($this->productionHost, $this->devHost, Config::isProduction());
    }

    protected function getPath(): ?string
    {
        return $this->path;
    }

    protected function resolveAuth(Model $model): ?Auth
    {
        if ($auth = $this->auth) {
            return $auth::make($model, $this, $this->hash, $this->authExtra);
        }

        return null;
    }
}
