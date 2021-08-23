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
use Helldar\Cashier\Facades\Helpers\JSON as JsonDecoder;
use Helldar\Contracts\Cashier\Http\Request;
use Helldar\Contracts\Exceptions\Http\ClientException;
use Helldar\Contracts\Exceptions\Manager as ExceptionManagerContract;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Http
{
    protected $client;

    protected $tries = 10;

    protected $sleep = 500;

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

            $options = $request->getHttpOptions();

            return retry($this->tries, function () use ($method, $uri, $data, $headers, $exception, $options) {
                $params = compact('headers') + $options + $this->body($data, $headers);

                /** @var \Psr\Http\Message\ResponseInterface $response */
                $response = $this->client->{$method}($uri, $params);

                $content = $this->decode($response);

                $exception->validateResponse($uri, $content, $response->getStatusCode());

                return $content;
            }, $this->sleep);
        } catch (ClientException $e) {
            throw $e;
        } catch (GuzzleClientException $e) {
            $response = $e->getResponse();

            $content = $this->decode($response);

            $exception->throw($request->uri(), $response->getStatusCode(), $content);
        } catch (Throwable $e) {
            $exception->throw($request->uri(), $e->getCode(), [
                'Message' => $e->getMessage(),
            ]);
        }
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
}
