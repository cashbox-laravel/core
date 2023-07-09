<?php

/*
 * This file is part of the "cashier-provider/tinkoff-online" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/cashier-provider/tinkoff-online
 */

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
