<?php

declare(strict_types=1);

namespace Helldar\Cashier\Config\Queues;

use Helldar\Contracts\Cashier\Config\Queues\Names as Contract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Names extends DataTransferObject implements Contract
{
    protected $start;

    protected $check;

    protected $refund;

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function getCheck(): ?string
    {
        return $this->check;
    }

    public function getRefund(): ?string
    {
        return $this->refund;
    }
}
