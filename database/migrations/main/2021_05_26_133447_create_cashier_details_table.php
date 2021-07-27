<?php

use Helldar\Cashier\Facades\Config\Main;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierDetailsTable extends Migration
{
    public function up()
    {
        Schema::create($this->table(), function (Blueprint $table) {
            $table->morphs('item');

            $table->string('payment_id')->nullable();

            $table->json('details')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table());
    }

    protected function table(): string
    {
        return Main::tableDetails();
    }
}
