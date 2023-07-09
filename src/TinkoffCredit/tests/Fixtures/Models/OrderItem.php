<?php

namespace Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class OrderItem extends Model
{
    protected $fillable = ['name', 'quantity', 'price'];

    protected $casts = [
        'quantity' => 'int',
        'price'    => 'float',
    ];

    public function __construct()
    {
        parent::__construct([
            'name'     => TestCase::ORDER_ITEM_TITLE,
            'quantity' => 1,
            'price'    => TestCase::PAYMENT_SUM,
        ]);
    }
}
