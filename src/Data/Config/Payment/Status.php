<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Payment;

use BackedEnum;
use CashierProvider\Core\Constants\Status as StatusConst;
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

    public function get(string $status): string|int|BackedEnum
    {
        return match ($status) {
            StatusConst::NEW         => $this->new,
            StatusConst::SUCCESS     => $this->success,
            StatusConst::FAILED      => $this->failed,
            StatusConst::REFUND      => $this->refund,
            StatusConst::WAIT_REFUND => $this->waitRefund
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
            $this->success,
            $this->failed,
        ];
    }
}
