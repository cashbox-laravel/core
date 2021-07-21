<?php

namespace Helldar\Cashier\Helpers;

use GuzzleHttp\Client;
use Helldar\Cashier\Contracts\ClientException;
use Helldar\Cashier\Exceptions\BadRequestException;
use Helldar\Cashier\Exceptions\EmptyResponseException;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Throwable;

class Http
{
    protected $client;

    protected $tries = 10;

    protected $sleep = 1;

    protected $status_keys = ['success'];

    protected $status_messages = ['details', 'message'];

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
                $params = compact('headers') + $this->body($data, $headers);

                Log::info('REQUEST', compact('uri', 'data', 'headers'));

                /** @var \Psr\Http\Message\ResponseInterface $response */
                $response = $this->client->{$method}($uri, $params);

                $content = $this->decode($response);

                $this->validateResponse($method, $uri, $response->getStatusCode(), $content);

                return $content;
            }, $this->sleep);
        }
        catch (ClientException $e) {
            throw $e;
        }
        catch (Throwable $e) {
            $this->abort($e->getMessage(), $e->getCode(), $method, $uri);
        }
    }

    protected function validateResponse(string $method, UriInterface $uri, int $status_code, array $content): void
    {
        if ($this->isFailedCode($status_code) || $this->isFailedContent($content)) {
            $message = $this->failedReason($content);

            $this->abort($message);
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

    protected function failedReason(array $content): string
    {
        $content = $this->lowerKeys($content);

        foreach ($this->status_messages as $key) {
            if (Arr::exists($content, $key)) {
                return Arr::get($content, $key);
            }
        }

        return 'Bad response';
    }

    protected function decode(ResponseInterface $response): array
    {
        if ($content = json_decode($response->getBody()->getContents(), true)) {
            return $content;
        }

        throw new EmptyResponseException();
    }

    protected function abort(string $message, int $code = 400, string $method = null, UriInterface $uri = null): void
    {
        if (! empty($method) && ! empty($uri)) {
            $method = Str::upper($method);

            $message = sprintf('%s %s: %s', $method, (string) $uri, $message);
        }

        throw new BadRequestException($message, $code);
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
