<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Http;

use Cashbox\Core\Concerns\Config\Application;
use Cashbox\Core\Enums\HttpMethodEnum;
use Cashbox\Core\Resources\Resource;
use Cashbox\Core\Services\Auth;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Http\Url;

abstract class Request
{
    use Application;
    use Makeable;

    protected HttpMethodEnum $method = HttpMethodEnum::post;

    protected string $productionHost;

    protected ?string $devHost = null;

    protected string $productionUri;

    protected ?string $devUri = null;

    protected bool $secure = true;

    protected Auth|string|null $auth = null;

    abstract public function body(): array;

    public function __construct(
        public readonly Resource $resource,
        public readonly ?Response $response = null
    ) {}

    public function url(): ?string
    {
        $host = static::isProduction() ? $this->productionHost : ($this->devHost ?? $this->productionHost);
        $uri  = static::isProduction() ? $this->productionUri : ($this->devUri ?? $this->productionUri);

        return Url::parse($host)->withPath($uri)->toUrl();
    }

    public function headers(): array
    {
        return [];
    }

    public function options(): array
    {
        return [];
    }

    public function method(): HttpMethodEnum
    {
        return $this->method;
    }

    public function sign(): ?Auth
    {
        if (! is_string($this->auth)) {
            return $this->auth;
        }

        return $this->auth = new $this->auth($this, $this->resource->config, $this->secure, $this->authExtra());
    }

    protected function authExtra(): array
    {
        return [];
    }
}
