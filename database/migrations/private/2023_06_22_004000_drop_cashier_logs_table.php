<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

use Cashbox\Core\Concerns\Migrations\PrivateMigration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends PrivateMigration {
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
