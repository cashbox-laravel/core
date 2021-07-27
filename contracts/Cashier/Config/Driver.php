<?php

declare(strict_types=1);

namespace Helldar\Contracts\Cashier\Config;

use Helldar\Contracts\DataTransferObject\DataTransferObject;

interface Driver extends DataTransferObject
{
    public function getDriver(): string;

    public function getResource(): string;

    public function getClientId(): ?string;

    public function getClientSecret(): ?string;
}
