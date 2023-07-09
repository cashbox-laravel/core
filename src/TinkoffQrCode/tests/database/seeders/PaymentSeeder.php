<?php

namespace Tests\database\seeders;

use Illuminate\Database\Seeder;
use Tests\Fixtures\Factories\Payment;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        Payment::create();
    }
}
