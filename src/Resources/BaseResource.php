<?php

namespace Helldar\Cashier\Resources;

use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Payment as Contract;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

abstract class BaseResource implements Contract
{
    use Makeable;
    use Validators;

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
