<?php

namespace Helldar\Cashier\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

interface Payment extends Arrayable
{
    public function __construct(Model $model);

    public function getUniqueId(bool $every = false): string;

    public function getPaymentId(): string;

    public function getSum(): int;

    public function getCurrency(): string;

    public function getCreatedAt(): string;

    public function getNow(): string;
}
