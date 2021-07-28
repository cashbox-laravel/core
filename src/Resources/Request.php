<?php

declare(strict_types=1);

namespace Helldar\Cashier\Resources;

use Helldar\Cashier\Facades\Config\Main;
use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\Contracts\Cashier\Resources\Request as Contract;
use Helldar\Contracts\Http\Builder as HttpBuilderContract;
use Helldar\Support\Facades\Http\Builder as HttpBuilder;

abstract class Request implements Contract
{
    /** @var \Helldar\Contracts\Cashier\Resources\Model */
    protected $model;

    /** @var string */
    protected $production_host;

    /** @var string */
    protected $dev_host;

    /** @var string|null */
    protected $path;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function uri(): HttpBuilderContract
    {
        $host = $this->getHost();

        return HttpBuilder::parse($host)->withPath($this->path);
    }

    protected function getHost(): string
    {
        return ! Main::isProduction() && $this->dev_host
            ? $this->dev_host
            : $this->production_host;
    }
}
