<?php

use Helldar\Cashier\Facades\Config\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePaymentsTableAddCashierIndex extends Migration
{
    public function up()
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->index($this->fields());
        });
    }

    public function down()
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->dropIndex($this->fields());
        });
    }

    protected function fields(): array
    {
        return [
            $this->attributeType(),
            $this->attributeStatus(),
            $this->attributeCreatedAt(),
        ];
    }

    protected function table(): string
    {
        return $this->model()->getTable();
    }

    protected function model(): Model
    {
        $model = Payment::model();

        return new $model();
    }

    protected function attributeType(): string
    {
        return Payment::attributeType();
    }

    protected function attributeStatus(): string
    {
        return Payment::attributeStatus();
    }

    protected function attributeCreatedAt(): string
    {
        return 'created_at';
    }
}
