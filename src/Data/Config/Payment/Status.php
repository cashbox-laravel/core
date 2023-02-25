<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Payment;

use CashierProvider\Core\Enums\Status as StatusEnum;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class Status extends Data
{
    public mixed $new;

    public mixed $success;

    public mixed $failed;

    public mixed $refund;

    public mixed $waitRefund;

    public function get(StatusEnum $status): mixed
    {
        return match ($status) {
            StatusEnum::new        => $this->new,
            StatusEnum::success    => $this->success,
            StatusEnum::failed     => $this->failed,
            StatusEnum::refund     => $this->refund,
            StatusEnum::waitRefund => $this->waitRefund
        };
    }

    public function inProgress(): array
    {
        return [
            $this->new,
            $this->waitRefund,
        ];
    }

    public function toRefund(): array
    {
        return [
            $this->new,
            $this->success,
            $this->failed,
        ];
    }
}
