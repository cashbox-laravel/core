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

namespace CashierProvider\Core\Concerns\Migrations;

use CashierProvider\Core\Concerns\Config\Details;
use CashierProvider\Core\Concerns\Config\Payment\Payments;
use DragonCode\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

abstract class PrivateMigration extends Migration
{
    use Details;
    use InitModelHelper;
    use Payments;

    protected function connection(): Builder
    {
        return Schema::connection(static::details()->connection);
    }

    protected function table(): string
    {
        return static::details()->table;
    }

    protected function primaryTable(): string
    {
        return $this->model()->table(
            static::payment()->model
        );
    }

    protected function primaryType(): string
    {
        return $this->model()->primaryKeyType(
            static::payment()->model
        );
    }

    protected function primaryKey(): string
    {
        return $this->model()->primaryKey(
            static::payment()->model
        );
    }
}
