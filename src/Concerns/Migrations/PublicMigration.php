<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Concerns\Migrations;

use CashierProvider\Core\Concerns\Attributes;
use CashierProvider\Core\Facades\Config;
use DragonCode\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

abstract class PublicMigration extends Migration
{
    use Attributes;
    use InitModelHelper;

    protected function schemaConnection(): Builder
    {
        $name = $this->model()->connection(
            $this->getModel()
        );

        return Schema::connection($name);
    }

    protected function table(): string
    {
        return $this->model()->table(
            $this->getModel()
        );
    }

    protected function getModel(): string
    {
        return Config::payment()->model;
    }
}
