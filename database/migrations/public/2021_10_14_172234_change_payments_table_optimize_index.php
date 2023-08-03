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
 * @see https://cashbox.city
 */

declare(strict_types=1);

use Cashbox\Core\Concerns\Migrations\PublicMigration;
use Illuminate\Database\Schema\Blueprint;

return new class extends PublicMigration {
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
            self::attributeConfig()->type,
            self::attributeConfig()->status,
            self::attributeConfig()->createdAt,
        ];
    }

    protected function newFields(): array
    {
        return [
            self::attributeConfig()->type,
            self::attributeConfig()->status,
        ];
    }
};
