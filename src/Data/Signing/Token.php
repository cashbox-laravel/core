<?php

declare(strict_types=1);

namespace Cashbox\Core\Data\Signing;

use DateTimeInterface;
use Spatie\LaravelData\Data;

class Token extends Data
{
    public ?string $clientId;

    public ?string $clientSecret;

    public ?DateTimeInterface $expiresIn;
}
