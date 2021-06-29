<?php

namespace Helldar\Cashier\Helpers;

use GuzzleHttp\Client;
use Helldar\Cashier\Exceptions\BadRequestException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

final class Http
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function post(string $uri, array $data, array $headers): array
    {
        return $this->request('post', $uri, $data, $headers);
    }

    protected function request(string $method, string $uri, array $data, array $headers): array
    {
        try {
            $response = $this->client->{$method}($uri, compact('data', 'headers'));

            $code = $response->getStatusCode();

            if ($this->success($code)) {
                return $this->decode($response);
            }

            $reason = $response->getReasonPhrase();

            $this->abort($reason, $code);
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
}
