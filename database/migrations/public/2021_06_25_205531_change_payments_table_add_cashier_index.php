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

use CashierProvider\Core\Concerns\Migrations\PublicMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

new class extends PublicMigration {
    public function up(): void
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->index($this->fields());
        });
    }

    public function down(): void
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
};
