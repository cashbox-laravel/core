<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Data\Config\Payment;

use BackedEnum;
use Cashbox\Core\Enums\StatusEnum;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class StatusData extends Data
{
    public BackedEnum|int|string $new;

    public BackedEnum|int|string $success;

    public BackedEnum|int|string $refund;

    public BackedEnum|int|string $waitRefund;

    public BackedEnum|int|string $failed;

    public function fromEnum(StatusEnum $status): BackedEnum|int|string
    {
        return match ($status) {
            StatusEnum::New        => $this->new,
            StatusEnum::Success    => $this->success,
            StatusEnum::Refund     => $this->refund,
            StatusEnum::WaitRefund => $this->waitRefund,
            StatusEnum::Failed     => $this->failed,
        };
    }

    public function toEnum(mixed $status): ?StatusEnum
    {
        return match ($status) {
            $this->new        => StatusEnum::New,
            $this->success    => StatusEnum::Success,
            $this->refund     => StatusEnum::Refund,
            $this->waitRefund => StatusEnum::WaitRefund,
            $this->failed     => StatusEnum::Failed,
            default           => null
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
        ];
    }
}
