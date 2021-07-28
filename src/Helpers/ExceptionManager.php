<?php

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use Helldar\Cashier\Exceptions\Http\BadRequestClientException;
use Helldar\Contracts\Cashier\Exceptions\ExceptionManager as Contract;
use Helldar\Contracts\Http\Builder;
use Helldar\Support\Facades\Helpers\Arr;

abstract class ExceptionManager implements Contract
{
    protected $codes = [];

    protected $default = BadRequestClientException::class;

    public function throw(Throwable $e, Builder $uri): void
    {
        $exception = $this->get($code);

        throw new $exception($uri);
    }

    protected function get($code): string
    {
        return Arr::get($this->codes, $code, $this->default);
    }
}
