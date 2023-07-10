<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

use CashierProvider\Core\Concerns\Migrations\PrivateMigration;
use Illuminate\Database\Schema\Blueprint;

new class extends PrivateMigration {
    public function up(): void
    {
        $this->connection()->table($this->table(), function (Blueprint $table) {
            $table->renameColumn('details', 'info');
        });
    }
};
