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

use CashierProvider\Core\Concerns\Migrations\PublicMigration;
use Illuminate\Database\Schema\Blueprint;

new class extends PublicMigration {
    public function up(): void
    {
        $this->connection()->table($this->table(), function (Blueprint $table) {
            $table->dropIndex($this->oldFields());
            $table->index($this->newFields());
        });
    }

    protected function oldFields(): array
    {
        return [
            self::attribute()->type,
            self::attribute()->status,
            self::attribute()->createdAt,
        ];
    }

    protected function newFields(): array
    {
        return [
            self::attribute()->type,
            self::attribute()->status,
        ];
    }
};
