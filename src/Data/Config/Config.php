<?php

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Data\Config\Payment\Payment;
use CashierProvider\Core\Data\Config\Queue\Queue;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class Config extends Data
{
    #[MapInputName('env')]
    public string $environment;

    public Payment $payment;

    public Connection $connection;

    public Logs $logs;

    public Queue $queue;

    public Check $check;

    #[MapInputName('auto_refund')]
    public Refund $refund;

    #[DataCollectionOf(Driver::class)]
    public DataCollection $drivers;

    public function payment(): Payment
    {
        return $this->payment;
    }

    public function connection(): Connection
    {
        return $this->connection;
    }

    public function logs(): Logs
    {
        return $this->logs;
    }

    public function queue(): Queue
    {
        return $this->queue;
    }

    public function check(): Check
    {
        return $this->check;
    }

    public function refund(): Refund
    {
        return $this->refund;
    }

    public function drivers(): DataCollection
    {
        return $this->drivers;
    }

    public function isProduction(): bool
    {
        return $this->environment === 'production';
    }

    public function getDriver(string|int $name): Driver
    {
        return $this->drivers->offsetGet($name);
    }
}
