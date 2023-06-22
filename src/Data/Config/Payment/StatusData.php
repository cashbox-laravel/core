<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config\Payment;

use CashierProvider\Core\Enums\Status as StatusEnum;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class StatusData extends Data
{
    public mixed $new;

    public mixed $success;

    public mixed $refund;

    public mixed $waitRefund;

    public mixed $failed;

    public function get(StatusEnum $status): mixed
    {
        return match ($status) {
            StatusEnum::new        => $this->new,
            StatusEnum::success    => $this->success,
            StatusEnum::refund     => $this->refund,
            StatusEnum::waitRefund => $this->waitRefund,
            StatusEnum::failed     => $this->failed,
        };
    }

    public function inProgress(): array
    {
        return [
            $this->new,
            $this->waitRefund,
        ];
    }

    public function allowToRefund(): array
    {
        return [
            $this->new,
            $this->success,
            $this->failed,
        ];
    }
}
