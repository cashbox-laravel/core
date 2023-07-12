<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Concerns\Helpers\Logging;
use CashierProvider\Core\Http\Request;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http as Client;

class Http
{
    use Logging;

    protected int $tries = 5;

    protected int $sleep = 300;

    public function send(Request $request, Exception $exception): array
    {
        $response = $this->request(
            $request->uri(),
            $request->headers(),
            $request->options(),
            $request->body(),
            $request->asJson,
            $request->post
        )->onError(
            fn (Response $instance) => $exception->throw(
                (string) $instance->effectiveUri(),
                $instance->status(),
                $instance->json()
            )
        );

        static::log($request, $response);

        return $response->json();
    }

    protected function request(
        string $uri,
        array $headers,
        array $options,
        array $data,
        bool $asJson,
        bool $asPost
    ): Response {
        return Client::withHeaders($headers)
            ->retry($this->tries, $this->sleep)
            ->withOptions($options)
            ->when(
                $asJson,
                fn (PendingRequest $request) => $request->asJson()->acceptJson(),
                fn (PendingRequest $request) => $request->asMultipart()
            )
            ->when(
                $asPost,
                fn (PendingRequest $request) => $request->post($uri, $data),
                fn (PendingRequest $request) => $request->get($uri, $data)
            );
    }
}
