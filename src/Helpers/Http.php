<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use Helldar\Cashier\Exceptions\Logic\EmptyResponseException;
use Helldar\Cashier\Facades\Config\Main;
use Helldar\Cashier\Facades\Helpers\JSON as JsonDecoder;
use Helldar\Contracts\Cashier\Http\Request;
use Helldar\Contracts\Exceptions\Http\ClientException;
use Helldar\Contracts\Exceptions\Manager as ExceptionManagerContract;
use Helldar\Contracts\Http\Builder;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Http
{
    protected $client;

    protected $tries = 10;

    protected $sleep = 500;

    protected $status_keys = ['success'];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \Helldar\Contracts\Exceptions\Http\ClientException
     */
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
            $curl    = $request->getCurlOptions();

            $verify = $this->sslVerify();

            return retry($this->tries, function () use ($method, $uri, $data, $headers, $exception, $verify, $curl) {
                $params = compact('headers', 'verify', 'curl') + $this->body($data, $headers);

                /** @var \Psr\Http\Message\ResponseInterface $response */
                $response = $this->client->{$method}($uri, $params);

                $content = $this->decode($response);

                $this->validateResponse($uri, $response->getStatusCode(), $content, $exception);

                return $content;
            }, $this->sleep);
        } catch (ClientException $e) {
            throw $e;
        } catch (GuzzleClientException $e) {
            $response = $e->getResponse();

            $content = $this->decode($response);

            $exception->throw($request->uri(), $response->getStatusCode(), [
                'Message' => Arr::get($content, 'moreInformation') ?: Arr::get($content, 'httpMessage'),
            ]);
        } catch (Throwable $e) {
            $exception->throw($request->uri(), $e->getCode(), [
                'Message' => $e->getMessage(),
            ]);
        }
    }

    protected function validateResponse(Builder $uri, int $status_code, array $content, ExceptionManagerContract $exception): void
    {
        if ($this->isFailedCode($status_code) || $this->isFailedContent($content)) {
            $exception->throw($uri, $status_code, $content);
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
        if ($content = JsonDecoder::decode($response->getBody()->getContents())) {
            return $content;
        }

        throw new EmptyResponseException('');
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

    protected function sslVerify()
    {
        return Main::getHttp()->sslVerify();
    }
}
