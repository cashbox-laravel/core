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
use Illuminate\Database\Schema\Blueprint;

return new class extends PrivateMigration {
    public function up(): void
    {
        $this->connection()->create($this->table(), function (Blueprint $table) {
            $table->string('item_type');

            match ($this->primaryType()) {
                'uuid'  => $table->uuid('item_id')->index()->after('item_type'),
                'ulid'  => $table->char('item_id', 26)->index()->after('item_type'),
                default => $table->unsignedBigInteger('item_id')->index()->after('item_type')
            };

            $table->string('external_id')->nullable();

            $table->json('details')->nullable();

            $table->timestamps();

            $table->index(['item_type', 'item_id']);
        });
    }
};
