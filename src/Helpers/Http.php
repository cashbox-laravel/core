<?php

namespace Helldar\Cashier\Helpers;

use GuzzleHttp\Client;
use Helldar\Cashier\Exceptions\BadRequestException;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Throwable;

class Http
{
    protected $client;

    protected $tries = 5;

    protected $sleep = 1;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function post(UriInterface $uri, array $data, array $headers): array
    {
        return $this->request('post', $uri, $data, $headers);
    }

    protected function request(string $method, UriInterface $uri, array $data, array $headers): array
    {
        try {
            return retry($this->tries, function () use ($method, $uri, $data, $headers) {
                $response = $this->client->{$method}($uri, compact('headers') + $this->body($data, $headers));

                $code = $response->getStatusCode();

                if ($this->success($code)) {
                    return $this->decode($response);
                }

                $reason = $response->getReasonPhrase();

                $this->abort($reason, $code);
            }, $this->sleep);
        }
        catch (Throwable $e) {
            $this->abort($e->getMessage(), $e->getCode());
        }
    }

    protected function success(int $status_code): bool
    {
        return 200 <= $status_code && $status_code < 400;
    }

    protected function decode(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    protected function abort(string $message, int $code): void
    {
        throw new BadRequestException($message, $code);
    }

    protected function body(array $data, array $headers): array
    {
        $headers = Arr::renameKeys($headers, static function ($key) {
            return Str::lower($key);
        });

        if (Arr::get($headers, 'content-type') === 'application/x-www-form-urlencoded') {
            return ['form_params' => $data];
        }

        return ['json' => $data];
    }
}
