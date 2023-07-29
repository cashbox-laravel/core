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

namespace Cashbox\Core\Http;

use Cashbox\Core\Data\Models\InfoData;
use DragonCode\Support\Facades\Helpers\Arr;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Wrapping\WrapExecutionType;

abstract class Response extends Data
{
    abstract public function getInfo(): InfoData;

    abstract public function getOperationId(): ?string;

    public function getExternalId(): ?string
    {
        return null;
    }

    public function isEmpty(): bool
    {
        return empty($this->filter($this->toArray()));
    }

    public function transform(
        bool $transformValues = true,
        WrapExecutionType $wrapExecutionType = WrapExecutionType::Disabled,
        bool $mapPropertyNames = true,
    ): array {
        return $this->filter(
            parent::transform($transformValues, $wrapExecutionType, $mapPropertyNames)
        );
    }

    protected function getExtra(): array
    {
        return [];
    }

    protected function filter(array $items): array
    {
        return Arr::filter($items, fn (mixed $value) => $value !== null);
    }
}
