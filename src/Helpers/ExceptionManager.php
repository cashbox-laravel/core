<?php

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Exceptions\Client\BadRequestClientException;
use Helldar\Contracts\Cashier\Exceptions\ExceptionManager as Contract;
use Helldar\Support\Facades\Helpers\Arr;
use Psr\Http\Message\UriInterface;

abstract class ExceptionManager implements Contract
{
    protected $codes = [];

    protected $default = BadRequestClientException::class;

    public function throw(?int $code, UriInterface $uri): void
    {
        $exception = $this->get($code);

        throw new $exception($uri);
    }

    protected function get($code): string
    {
        return Arr::get($this->codes, $code, $this->default);
    }
}
