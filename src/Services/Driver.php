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
use CashierProvider\Core\Http\ResponseInfo;
use Illuminate\Database\Eloquent\Model;

abstract class Driver
{
    protected string $statuses;

    protected string $exception;

    protected string $info;

    abstract public function refund(): ResponseInfo;

    abstract public function start(): ResponseInfo;

    abstract public function verify(): ResponseInfo;

    public function __construct(
        protected Model $payment,
        protected readonly DriverData $data,
        protected readonly Http $http
    ) {}

    public function statuses(): Statuses
    {
        return resolve($this->statuses, [$this->payment]);
    }

    protected function request(string $request): ResponseInfo
    {
        $client = $this->resolve($request, 'make', $this->payment);

        $content = $this->http->send($client, $this->resolveException());

        return $this->resolve($this->info, 'from', $content);
    }

    protected function resolveException(): Exception
    {
        return resolve($this->exception);
    }

    protected function resolve(string $class, string $method, mixed ...$parameters): object
    {
        return call_user_func([$class, $method], ...$parameters);
    }
}
