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

use Cashbox\Core\Concerns\Migrations\PrivateMigration;
use Illuminate\Support\Facades\DB;

return new class extends PrivateMigration {
    protected array $files = [
        '2021_09_10_115126_create_cashier_increment_field',
        '2021_09_10_120000_create_cashier_logs_table',
        '2021_10_12_125617_change_cashier_details_table_add_operation_id_column',
    ];

    public function up(): void
    {
        DB::table('migrations')
            ->whereIn('migration', $this->files)
            ->delete();
    }
};
