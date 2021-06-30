<?php

namespace Helldar\Cashier\Contracts;

interface Auth
{
    public function setClientId(?string $id): self;

    public function getClientId(): ?string;

    public function setClientSecret(?string $secret): self;

    public function getClientSecret(): ?string;

    public function doesntEmpty(): bool;
}
