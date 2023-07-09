<?php

namespace Tests\database\seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(PaymentSeeder::class);
    }
}
