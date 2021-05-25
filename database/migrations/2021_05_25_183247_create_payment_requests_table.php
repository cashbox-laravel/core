<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('payment_requests', function (Blueprint $table) {
            $table->morphs('payment');

            $table->string('status_id')->nullable();

            $table->string('url');

            $table->json('request')->nullable();
            $table->json('response')->nullable();

            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_requests');
    }
}
