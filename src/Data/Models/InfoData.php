<?php

declare(strict_types=1);

namespace Cashbox\Core\Data\Models;

use Cashbox\Core\Concerns\Config\Application;
use Cashbox\Core\Support\Arr;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Support\Wrapping\WrapExecutionType;
use Stringable;

#[MapName(SnakeCaseMapper::class)]
class InfoData extends Data implements Stringable
{
    use Application;

    public ?string $externalId;

    public ?string $operationId;

    public ?string $status;

    public ?array $extra;

    public function toJson($options = 0): string
    {
        return parent::toJson($this->flags());
    }

    public function transform(
        bool $transformValues = true,
        WrapExecutionType $wrapExecutionType = WrapExecutionType::Disabled,
        bool $mapPropertyNames = true,
    ): array {
        return $this->filter(parent::transform($transformValues, $wrapExecutionType, $mapPropertyNames));
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    protected function flags(): int
    {
        return static::isProduction()
            ? JSON_UNESCAPED_SLASHES ^ JSON_UNESCAPED_UNICODE ^ JSON_NUMERIC_CHECK
            : JSON_UNESCAPED_SLASHES ^ JSON_UNESCAPED_UNICODE ^ JSON_NUMERIC_CHECK ^ JSON_PRETTY_PRINT;
    }

    protected function filter(array $items): array
    {
        return Arr::filter($items);
    }
}
