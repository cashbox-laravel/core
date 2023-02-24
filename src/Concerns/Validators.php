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

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Exceptions\Runtime\Implement\IncorrectDriverException;
use CashierProvider\Core\Exceptions\Runtime\Implement\IncorrectPaymentModelException;
use CashierProvider\Core\Exceptions\Runtime\Implement\UnknownResponseException;
use CashierProvider\Core\Exceptions\Runtime\UnknownMethodException;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Http\Response;
use CashierProvider\Core\Services\Driver;
use DragonCode\Support\Facades\Instances\Instance;
use Illuminate\Database\Eloquent\Model;

trait Validators
{
    protected function validateModel($model): Model
    {
        return $this->validate($model, Config::payment()->model, IncorrectPaymentModelException::class);
    }

    protected function validateDriver(string $driver): string
    {
        return $this->validate($driver, Driver::class, IncorrectDriverException::class);
    }

    protected function validateResponse(?string $response): ?string
    {
        return $this->validate($response, Response::class, UnknownResponseException::class);
    }

    protected function validateMethod(string $haystack, string $method): void
    {
        throw new UnknownMethodException($haystack, $method);
    }

    protected function validate($haystack, string $needle, string $exception): mixed
    {
        if (! Instance::of($haystack, $needle)) {
            throw new $exception($haystack);
        }

        return $haystack;
    }
}
