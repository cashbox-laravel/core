<?php

/*
 * This file is part of the "cashier-provider/core" project.
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
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Helpers;

use CashierProvider\Core\Concerns\FailedEvent;
use CashierProvider\Core\Concerns\Logs;
use CashierProvider\Core\Exceptions\Http\UnauthorizedException;
use CashierProvider\Core\Exceptions\Logic\EmptyResponseException;
use CashierProvider\Core\Facades\Helpers\JSON as JsonDecoder;
use DragonCode\Contracts\Cashier\Http\Request;
use DragonCode\Contracts\Exceptions\Http\ClientException;
use DragonCode\Contracts\Exceptions\Manager as ExceptionManagerContract;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use Lmc\HttpConstants\Header;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Http
{
    use FailedEvent;
    use Logs;

    protected $client;

    protected $tries = 10;

    protected $sleep = 300;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param \DragonCode\Contracts\Cashier\Http\Request $request
     * @param \DragonCode\Contracts\Exceptions\Manager $manager
     *
     * @throws \DragonCode\Contracts\Exceptions\Http\ClientException
     *
     * @return array
     */
    public function post(Request $request, ExceptionManagerContract $manager): array
    {
        return $this->request('post', $request, $manager);
    }

    protected function request(string $method, Request $request, ExceptionManagerContract $exception): array
    {
        try {
            return $this->retry($this->tries, function () use ($method, $request, $exception) {
                $uri     = $request->uri();
                $headers = $request->headers();
                $data    = $request->body();

                $options = $request->getHttpOptions();

                $params = compact('headers') + $options + $this->body($data, $headers);

                /** @var \Psr\Http\Message\ResponseInterface $response */
                $response = $this->client->{$method}($uri, $params);

                $content = $this->decode($response);

                $status_code = $response->getStatusCode();

                $exception->validateResponse($uri, $content, $status_code);

                $this->logInfo($request->model(), $method, $uri, $data, $content, $status_code);

                return $content;
            }, $request);
        } catch (ClientException $e) {
            $this->failedEvent($e);

            $this->logError($request->model(), $method, $request, $e);

            throw $e;
        } catch (GuzzleClientException $e) {
            $response = $e->getResponse();

            $content = $this->decode($response);

            $this->logError($request->model(), $method, $request, $e);

            $exception->throw($request->uri(), $response->getStatusCode(), $content);
        } catch (Throwable $e) {
            $this->logError($request->model(), $method, $request, $e);

            $exception->throw($request->uri(), $e->getCode(), [
                'Message' => $e->getMessage(),
            ]);
        }
    }

    protected function retry(int $times, callable $callback, Request $request): array
    {
        $attempts = 0;

        beginning:
        $attempts++;
        --$times;

        try {
            return $callback($attempts);
        } catch (Throwable $e) {
            if ($times < 1) {
                throw $e;
            }

            if ($e instanceof UnauthorizedException) {
                $request->refreshAuth();
            }

            $this->sleep($attempts);

            goto beginning;
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

        if (Arr::get($headers, Header::CONTENT_TYPE) === 'application/x-www-form-urlencoded') {
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

    protected function sleep(int $attempts): void
    {
        usleep(value($this->sleep, $attempts) * 1000);
    }
}
