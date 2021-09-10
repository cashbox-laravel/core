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

use Helldar\Cashier\Facades\Config\Details;
use Helldar\Cashier\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierDetailsLogsTable extends Migration
{
    public function up()
    {
        Schema::create($this->logsTable(), function (Blueprint $table) {
            $table->bigIncrements('id')->primary();

            $this->isNumericPrimaryKey()
                ? $table->unsignedBigInteger('payment_id')->index()
                : $table->uuid('payment_id')->index();

            $table->string('external_id')->nullable();

            $table->unsignedBigInteger('sum');

            $table->string('currency');

            $table->string('method');
            $table->string('url');

            $table->unsignedSmallInteger('status_code');

            $table->json('request');
            $table->json('response');
            $table->json('extra');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->logsTable());
    }

    protected function logsTable(): string
    {
        return Details::getLogsTable();
    }

    protected function detailsTable(): string
    {
        return Details::getTable();
    }
}
