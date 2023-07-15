<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core\Services;

use Cashbox\Core\Concerns\Helpers\Logging;
use Cashbox\Core\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http as Client;

class Http
{
    use Logging;

    protected int $tries = 5;

    protected int $sleep = 300;

    public function send(Request $request, Exception $exception): array
    {
        if ($request->uri() === null) {
            return $request->body();
        }

        $response = $this->request(
            $request->uri(),
            $request->headers(),
            $request->options(),
            $request->body()
        );

        static::log($request, $response);

        $this->throwIf($response, $exception);

        return $response->json();
    }

    protected function request(string $uri, array $headers, array $options, array $data): Response
    {
        return Client::retry($this->tries, $this->sleep)
            ->withHeaders($headers)
            ->withOptions($options)
            ->acceptJson()
            ->asJson()
            ->post($uri, $data);
    }

    protected function throwIf(Response $response, Exception $exception): void
    {
        $exception->throw(
            (string) $response->effectiveUri(),
            $response->status(),
            $response->json()
        );
    }
}
