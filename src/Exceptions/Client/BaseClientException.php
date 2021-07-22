<?php

namespace Helldar\Cashier\Exceptions\Client;

use Helldar\Cashier\Contracts\ClientException;
use Psr\Http\Message\UriInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseClientException extends HttpException implements ClientException
{
    protected $status_code;

    protected $reason;

    public function __construct(UriInterface $uri)
    {
        $message = $this->message($uri);

        $code = $this->statusCode();

        parent::__construct($code, $message, null, [], $code);
    }

    protected function message(UriInterface $uri): string
    {
        $url = $this->url($uri);

        $reason = $this->reason();

        return $url . ': ' . $reason;
    }

    protected function reason(): string
    {
        return $this->reason;
    }

    protected function url(UriInterface $uri): string
    {
        return (string) $uri;
    }

    protected function statusCode(): int
    {
        return $this->status_code ?: 400;
    }
}
