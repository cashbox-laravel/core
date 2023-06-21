<?php

declare(strict_types=1);

namespace CashierProvider\Core\Casts\Data;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class LogChannelCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): LoggerInterface
    {
        return Log::channel($value);
    }
}
