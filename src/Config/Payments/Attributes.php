<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Config\Payments;

use Helldar\Contracts\Cashier\Config\Payments\Attributes as AttributesContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Attributes extends DataTransferObject implements AttributesContract
{
    protected $type;

    protected $status;

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
