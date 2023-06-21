<?php

declare(strict_types=1);

use CashierProvider\Core\Concerns\Migrations\PrivateMigration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

new class extends PrivateMigration {
    public function up(): void
    {
        $this->dropSchema();
        $this->cleanMigrations();
    }

    protected function dropSchema(): void
    {
        Schema::dropIfExists('cashier_logs');
    }

    protected function cleanMigrations(): void
    {
        DB::table('migrations')
            ->where('migration', '2021_09_10_120000_create_cashier_logs_table')
            ->delete();
    }
};
