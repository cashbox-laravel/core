<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

use CashierProvider\Core\Concerns\Migrations\PublicMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePaymentsTableOptimizeIndex extends PublicMigration
{
    /**
     * @throws \Helldar\LaravelSupport\Exceptions\IncorrectModelException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function up()
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->dropIndex($this->oldFields());
            $table->index($this->newFields());
        });
    }

    public function down()
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->dropIndex($this->newFields());
            $table->index($this->oldFields());
        });
    }

    protected function oldFields(): array
    {
        return [
            $this->attributeType(),
            $this->attributeStatus(),
            $this->attributeCreatedAt(),
        ];
    }

    protected function newFields(): array
    {
        return [
            $this->attributeType(),
            $this->attributeStatus(),
        ];
    }
}
