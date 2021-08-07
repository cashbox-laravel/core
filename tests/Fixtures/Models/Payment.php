<?php

namespace Tests\Fixtures\Models;

use Helldar\Cashier\Concerns\Casheable;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Casheable;
}
