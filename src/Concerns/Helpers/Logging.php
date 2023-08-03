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

namespace Cashbox\Core\Concerns\Helpers;

use Cashbox\Core\Facades\Config;
use Cashbox\Core\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

trait Logging
{
    protected static function log(Request $request, Response $response): void
    {
        $response->successful()
            ? static::info($request, $response)
            : static::error($request, $response);
    }

    protected static function info(Request $request, Response $response): void
    {
        static::logger($response)?->info(static::header($request, $response), [
            'request'  => $request->body(),
            'response' => $response->json(),
        ]);
    }

    protected static function error(Request $request, Response $response): void
    {
        static::logger($response)?->error(static::header($request, $response), [
            'request'  => $request->body(),
            'response' => [
                'reason' => $response->reason(),
                'body'   => $response->body(),
            ],
        ]);
    }

    protected static function header(Request $request, Response $response): string
    {
        return sprintf(
            '%d %s, POST %s',
            $response->status(),
            static::status($response),
            $request->url()
        );
    }

    protected static function status(Response $response): string
    {
        return match (true) {
            $response->successful() => 'OK',
            $response->redirect()   => 'REDIRECT',
            default                 => 'FAIL'
        };
    }

    protected static function logger(Response $response): ?LoggerInterface
    {
        if ($channel = static::channel($response->failed())) {
            return Log::channel($channel);
        }

        return null;
    }

    protected static function channel(bool $failed): ?string
    {
        return $failed
            ? Config::logs()->error
            : Config::logs()->info;
    }
}
