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

use CashierProvider\Core\Data\Config\DriverData;
use CashierProvider\Core\Data\Http\ResponseData;
use CashierProvider\Core\Http\Request;
use CashierProvider\Core\Http\Response;
use Illuminate\Database\Eloquent\Model;

abstract class Driver
{
    protected string $statuses;

    protected string $exceptions;

    public function __construct(
        protected Model $payment,
        protected readonly DriverData $data,
        protected readonly Http $http
    ) {}

    public function statuses(): Statuses
    {
        return resolve($this->statuses, [$this->payment]);
    }

    public function start(): ResponseData {}

    public function verify(): ResponseData {}

    public function refund(): ResponseData {}

    protected function request(Request $request, string $response): Response
    {
        $exceptions = $this->resolveException();

        $content = $this->http->send($request, $exceptions);

        return new $response($content);
    }

    protected function resolveException(): Exception
    {
        return resolve($this->exceptions);
    }
}
