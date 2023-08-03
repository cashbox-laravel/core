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

namespace Cashbox\Core\Concerns\Migrations;

use Cashbox\Core\Concerns\Config\Details;
use Cashbox\Core\Concerns\Config\Payment\Payments;
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
        return Schema::connection(static::detailsConfig()->connection);
    }

    protected function table(): string
    {
        return static::detailsConfig()->table;
    }

    protected function primaryTable(): string
    {
        return $this->model()->table(
            static::paymentConfig()->model
        );
    }

    protected function primaryType(): string
    {
        return $this->model()->primaryKeyType(
            static::paymentConfig()->model
        );
    }

    protected function primaryKey(): string
    {
        return $this->model()->primaryKey(
            static::paymentConfig()->model
        );
    }
}
