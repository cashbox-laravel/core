<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Casts\Data\LogChannelCast;
use Psr\Log\LoggerInterface;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class LogsData extends Data
{
    public bool $enabled;

    #[WithCast(LogChannelCast::class)]
    public LoggerInterface $channel;
}
