<?php

namespace Helldar\Cashier\Contracts;

use Illuminate\Database\Eloquent\Model;

interface Statuses
{
    public function hasCreated(Model $model): bool;

    public function hasFailed(Model $model): bool;

    public function hasRefunded(Model $model): bool;

    public function hasRefunding(Model $model): bool;

    public function hasSuccess(Model $model): bool;

    public function inProgress(Model $model): bool;
}
