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
use Helldar\Cashier\Facades\Config\Logs;
use Helldar\Cashier\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierLogsTable extends Migration
{
    public function up()
    {
        Schema::connection($this->logsConnection())
            ->create($this->logsTable(), function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('item_type');

                $this->isNumericPrimaryKey()
                    ? $table->unsignedBigInteger('item_id')
                    : $table->uuid('item_id');

                $table->string('external_id')->nullable();

                $table->string('method');
                $table->string('url');

                $table->unsignedSmallInteger('status_code');

                $table->json('request');
                $table->json('response');
                $table->json('extra');

                $table->timestamps();

                $table->index(['item_type', 'item_id']);
            });
    }

    public function down()
    {
        Schema::connection($this->logsConnection())
            ->dropIfExists($this->logsTable());
    }

    protected function logsConnection(): ?string
    {
        return Logs::getConnection();
    }

    protected function logsTable(): string
    {
        return Logs::getTable();
    }

    protected function detailsTable(): string
    {
        return Details::getTable();
    }
}
