<?php

declare(strict_types=1);

namespace Cashbox\Core\Data\Models;

use Cashbox\Core\Concerns\Config\Application;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class InfoData extends Data
{
    use Application;

    public ?string $externalId;

    public ?string $operationId;

    public ?string $status;

    public function toJson($options = 0): string
    {
        return parent::toJson($this->flags());
    }

    protected function flags(): int
    {
        return static::isProduction()
            ? JSON_UNESCAPED_SLASHES ^ JSON_UNESCAPED_UNICODE ^ JSON_NUMERIC_CHECK
            : JSON_UNESCAPED_SLASHES ^ JSON_UNESCAPED_UNICODE ^ JSON_NUMERIC_CHECK ^ JSON_PRETTY_PRINT;
    }
}
