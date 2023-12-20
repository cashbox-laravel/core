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

use Cashbox\Core\Concerns\Config\Payment\Attributes;
use Cashbox\Core\Concerns\Config\Payment\Payments;
use DragonCode\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

abstract class PublicMigration extends Migration
{
    use Attributes;
    use InitModelHelper;
    use Payments;

    protected function connection(): Builder
    {
        return Schema::connection(
            $this->modelConnection()
        );
    }

    protected function modelConnection(): ?string
    {
        return $this->model()->connection(
            static::paymentConfig()->model
        );
    }

    protected function table(): string
    {
        return $this->model()->table(
            static::paymentConfig()->model
        );
    }
}
