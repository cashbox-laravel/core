<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Payment;

use CashierProvider\Core\Constants\Status as StatusConstant;
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

    public function get(string $status): mixed
    {
        return match ($status) {
            StatusConstant::NEW         => $this->new,
            StatusConstant::SUCCESS     => $this->success,
            StatusConstant::FAILED      => $this->failed,
            StatusConstant::REFUND      => $this->refund,
            StatusConstant::WAIT_REFUND => $this->waitRefund,
        };
    }
}
