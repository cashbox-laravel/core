<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Http;

use Helldar\Cashier\Concerns\Exceptionable;
use Helldar\Contracts\Cashier\Exceptions\Http\ClientException;
use Helldar\Contracts\Http\Builder;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseException extends HttpException implements ClientException
{
    use Exceptionable;

    public $default_status_code = 400;

    public function __construct(Builder $uri)
    {
        $message = $this->message($uri);

        $code = $this->getStatus();

        parent::__construct($code, $message, null, [], $code);
    }

    protected function message(Builder $uri): string
    {
        return $uri->toUrl() . ': ' . $this->getReason();
    }
}
