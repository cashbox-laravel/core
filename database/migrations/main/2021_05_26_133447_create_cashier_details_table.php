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
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierDetailsTable extends BaseMigration
{
    public function up()
    {
        Schema::create($this->table(), function (Blueprint $table) {
            $table->string('item_type');

            $this->isNumericPrimaryKey()
                ? $table->unsignedBigInteger('item_id')
                : $table->uuid('item_id');

            $table->string('external_id')->nullable();

            $table->json('details')->nullable();

            $table->timestamps();

            $table->index(['item_type', 'item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table());
    }

    protected function table(): string
    {
        return Details::getTable();
    }
}
