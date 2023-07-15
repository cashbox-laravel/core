<?php

declare(strict_types=1);

namespace Cashbox\Core\Data\Models;

use Cashbox\Core\Concerns\Config\Application;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class InfoData extends Data
{
    use Application;

    #[MapInputName('external_id')]
    public ?string $externalId;

    #[MapInputName('operation_id')]
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
