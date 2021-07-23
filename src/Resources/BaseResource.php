<?php

namespace Helldar\Cashier\Resources;

use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Payment as Contract;
use Helldar\Cashier\Facades\Unique;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

abstract class BaseResource implements Contract
{
    use Makeable;
    use Validators;

    /** @var \Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var string */
    protected $unique_id;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getUniqueId(bool $every = false): string
    {
        if (! empty($this->unique_id) && ! $every) {
            return $this->unique_id;
        }

        return $this->unique_id = Unique::uid();
    }
}
