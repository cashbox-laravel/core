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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Services;

use Cashbox\Core\Concerns\Helpers\Logging;
use Cashbox\Core\Enums\HttpMethodEnum;
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
        if ($request->url() === null) {
            return $request->body();
        }

        $response = $this->request(
            method : $request->method(),
            url    : $request->url(),
            headers: $request->sign()?->headers() ?? $request->headers(),
            options: $request->sign()?->options() ?? $request->options(),
            data   : $request->sign()?->body() ?? $request->body()
        );

        static::log($request, $response);

        $exception->throwIf($response);

        return $response->json();
    }

    protected function request(
        HttpMethodEnum $method,
        string $url,
        array $headers,
        array $options,
        array $data
    ): Response {
        return Client::retry($this->tries, $this->sleep)
            ->withHeaders($headers)
            ->withOptions($options)
            ->acceptJson()
            ->asJson()
            ->send($method->value, $url, $data);
    }
}
