<?php

namespace Helldar\Cashier\Contracts;

interface Statuses
{
    public function hasCreated(string $status): bool;

    public function hasFailed(string $status): bool;

    public function hasRefunded(string $status): bool;

    public function hasRefunding(string $status): bool;

    public function hasSuccess(string $status): bool;
}
