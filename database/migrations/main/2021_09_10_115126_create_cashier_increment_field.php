<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

use CashierProvider\Core\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierIncrementField extends Migration
{
    public function up()
    {
        Schema::table($this->detailsTable(), function (Blueprint $table) {
            $table->bigIncrements('id')->first();
        });
    }

    public function down()
    {
        Schema::table($this->detailsTable(), function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}
