<?php

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use GuzzleHttp\Client;
use Helldar\Cashier\Exceptions\Http\BadRequestClientException;
use Helldar\Cashier\Exceptions\Logic\EmptyResponseException;
use Helldar\Contracts\Cashier\Exceptions\ExceptionManager as ExceptionManagerContract;
use Helldar\Contracts\Cashier\Resources\Request;
use Helldar\Contracts\Http\Builder;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Http
{
    protected $client;

    protected $tries = 10;

    protected $sleep = 1;

    protected $status_keys = ['success'];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function post(Request $request, ExceptionManagerContract $manager): array
    {
        return $this->request('post', $request, $manager);
    }

    protected function request(string $method, Request $request, ExceptionManagerContract $exception): array
    {
        try {
            $uri     = $request->uri();
            $headers = $request->headers();
            $data    = $request->body();

            return retry($this->tries, function () use ($method, $uri, $data, $headers) {
                $params = compact('headers') + $this->body($data, $headers);

                /** @var \Psr\Http\Message\ResponseInterface $response */
                $response = $this->client->{$method}($uri, $params);

                $content = $this->decode($response);

                $this->validateResponse($uri, $response->getStatusCode(), $content);

                return $content;
            }, $this->sleep);
        } catch (BadRequestClientException $e) {
            throw $e;
        } catch (Throwable $e) {
            $exception->throw($e, $uri);
        }
    }

    protected function validateResponse(Builder $uri, int $status_code, array $content): void
    {
        if ($this->isFailedCode($status_code) || $this->isFailedContent($content)) {
            $this->abort($uri);
        }
    }

    protected function isFailedCode(int $code): bool
    {
        return $code < 200 || $code >= 400;
    }

    protected function isFailedContent(array $content): bool
    {
        $content = $this->lowerKeys($content);

        foreach ($this->status_keys as $key) {
            if (Arr::exists($content, $key)) {
                return $content[$key] === false;
            }
        }

        return false;
    }

    protected function decode(ResponseInterface $response): array
    {
        if ($content = json_decode($response->getBody()->getContents(), true)) {
            return $content;
        }

        throw new EmptyResponseException('');
    }

    protected function abort(Builder $uri): void
    {
        throw new BadRequestClientException($uri);
    }

    protected function body(array $data, array $headers): array
    {
        $headers = $this->lowerKeys($headers);

        if (Arr::get($headers, 'content-type') === 'application/x-www-form-urlencoded') {
            return ['form_params' => $data];
        }

        return ['json' => $data];
    }

    protected function lowerKeys(array $items): array
    {
        return Arr::renameKeys($items, static function (string $key) {
            return Str::lower($key);
        });
    }
}
