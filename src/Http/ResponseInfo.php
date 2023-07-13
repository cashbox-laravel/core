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

namespace CashierProvider\Core\Http;

use DragonCode\Support\Facades\Helpers\Arr;
use Spatie\LaravelData\Data;

abstract class ResponseInfo extends Data
{
    abstract public function getExternalId(): ?string;

    abstract public function getOperationId(): ?string;

    abstract public function getStatus(): ?string;

    public function isEmpty(): bool
    {
        return Arr::of($this->toArray())
            ->filter(fn (mixed $value) => $value !== null)
            ->isEmpty();
    }
}
