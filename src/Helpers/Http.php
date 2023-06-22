<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Helpers;

use CashierProvider\Core\Concerns\Events;
use CashierProvider\Core\Concerns\Logs;
use CashierProvider\Core\Exceptions\Manager;
use CashierProvider\Core\Http\Request;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Http\Builder;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http as HttpClient;
use Illuminate\Support\Str;
use Lmc\HttpConstants\Header;
use Throwable;

use function retry;

class Http
{
    use Events;
    use Logs;

    protected int $tries = 10;

    public function request(Request $request, Manager $exception): array
    {
        try {
            return retry($this->tries, function () use ($request, $exception) {
                $method  = $request->method();
                $uri     = $request->uri();
                $headers = $request->headers();
                $data    = $request->body();

                $response = $this->send($request, $method, $uri, $data, $headers);

                $content    = $response->json();
                $statusCode = $response->status();

                $exception->validateResponse($uri, $content, $statusCode);

                $this->log($request->model(), $method, $uri, $data, $content, $statusCode);

                return $content;
            }, $request);
        }
        catch (RequestException $e) {
            $this->failedEvent($e);

            $this->error($request->model(), $request, $e);

            $exception->throw($request->uri(), $e->response->status(), $e->response->json());
        }
        catch (Throwable $e) {
            $this->failedEvent($e);

            $this->error($request->model(), $request, $e);

            $exception->throw($request->uri(), $e->getCode(), [
                'Message' => $e->getMessage(),
            ]);
        }
    }

    protected function send(Request $request, string $method, Builder $uri, array $data, array $headers): Response
    {
        return HttpClient::withHeaders($headers)
            ->when($this->isJson($headers), fn (PendingRequest $request) => $request->asJson())
            ->when($this->doesntJson($headers), fn (PendingRequest $request) => $request->asMultipart())
            ->send($method, $uri->toUrl(), $data + $request->getHttpOptions())
            ->throw();
    }

    protected function isJson(array $headers): bool
    {
        return Arr::get($this->lowerKeys($headers), Header::CONTENT_TYPE) === 'application/x-www-form-urlencoded';
    }

    protected function doesntJson(array $headers): bool
    {
        return ! $this->isJson($headers);
    }

    protected function lowerKeys(array $items): array
    {
        return Arr::renameKeys($items, static fn (string $key) => Str::lower($key));
    }
}
