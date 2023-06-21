<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class CredentialsData extends Data
{
    public string $clientId;

    public string $clientSecret;
}
