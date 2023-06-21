<?php

/*
 * This file is part of the "cashier-provider/core" project.
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
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

use CashierProvider\Core\Concerns\Migrations\PrivateMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

new class extends PrivateMigration {
    public function up(): void
    {
        Schema::table($this->detailsTable(), function (Blueprint $table) {
            $table->string('operation_id')->nullable()->after('external_id');
        });
    }

    public function down(): void
    {
        Schema::table($this->detailsTable(), function (Blueprint $table) {
            $table->dropColumn('operation_id');
        });
    }
};
