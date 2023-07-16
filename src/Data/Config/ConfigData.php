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
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core\Data\Config;

use Cashbox\Core\Data\Config\Payment\PaymentData;
use Cashbox\Core\Data\Config\Queue\QueueData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ConfigData extends Data
{
    #[MapInputName('env')]
    public string $environment;

    public PaymentData $payment;

    public DetailsData $details;

    public LogsData $logs;

    public QueueData $queue;

    #[MapInputName('auto_refund')]
    public RefundData $refund;

    #[DataCollectionOf(DriverData::class)]
    public DataCollection $drivers;

    public function payment(): PaymentData
    {
        return $this->payment;
    }

    public function details(): DetailsData
    {
        return $this->details;
    }

    public function logs(): LogsData
    {
        return $this->logs;
    }

    public function queue(): QueueData
    {
        return $this->queue;
    }

    public function refund(): RefundData
    {
        return $this->refund;
    }

    public function driver(int|string $name): ?DriverData
    {
        if ($driver = $this->drivers[$name] ?? null) {
            return $driver;
        }

        return null;
    }

    public function isProduction(): bool
    {
        return $this->environment === 'production';
    }
}
