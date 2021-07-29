<?php

declare(strict_types=1);

namespace Helldar\Cashier\Resources;

use Helldar\Cashier\Facades\Helpers\JSON;
use Helldar\Contracts\Cashier\Resources\Details as DetailsContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

abstract class Details extends DataTransferObject implements DetailsContract
{
    protected $status;

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
        ];
    }

    public function toJson(int $options = 0): string
    {
        return JSON::encode($this->toArray());
    }
}
