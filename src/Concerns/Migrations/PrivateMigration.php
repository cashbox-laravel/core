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

namespace CashierProvider\Core\Concerns\Migrations;

use CashierProvider\Core\Data\Config\TableData;
use CashierProvider\Core\Facades\Config;
use DragonCode\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

abstract class PrivateMigration extends BaseMigration
{
    use InitModelHelper;

    protected function isNumericPrimaryKey(): bool
    {
        $type = $this->model()->primaryKeyType(
            Config::payment()->model
        );

        return Str::contains($type, ['int', 'integer'], true);
    }

    protected function details(): TableData
    {
        return Config::details();
    }

    protected function detailsConnection(): Builder
    {
        return Schema::connection($this->details()->connection);
    }

    protected function detailsTable(): string
    {
        return $this->details()->table;
    }
}
