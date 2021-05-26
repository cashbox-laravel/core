<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateCashierDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('cashier_details', function (Blueprint $table) {
            $table->morphs('item');

            $table->string('payment_id')->nullable();

            $table->json('details')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cashier_details');
    }
}
