<?php

namespace Helldar\Cashier\Resources;

use Helldar\Cashier\Concerns\Validators;
use Helldar\Cashier\Contracts\Payment as Contract;
use Helldar\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

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
        if (! empty($this->unique_id) && $every !== false) {
            return $this->unique_id;
        }

        return $this->unique_id = md5(Uuid::uuid4());
    }
}
