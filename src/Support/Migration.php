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

namespace Helldar\Cashier\Support;

use Helldar\Cashier\Facades\Config\Payment;
use Helldar\LaravelSupport\Traits\InitModelHelper;
use Helldar\Support\Facades\Helpers\Arr;
use Illuminate\Database\Migrations\Migration as BaseMigration;

abstract class Migration extends BaseMigration
{
    use InitModelHelper;

    protected function isNumericPrimaryKey(): bool
    {
        $model = Payment::getModel();

        $type = $this->model()->primaryKeyType($model);

        return in_array($type, ['int', 'integer']);
    }

    protected function doesntMemory(): bool
    {
        $name = config('database.default');

        $connection = config('database.connections.' . $name);

        $driver   = Arr::get($connection, 'driver');
        $database = Arr::get($connection, 'database');

        return $driver !== 'sqlite' && $database !== ':memory:';
    }
}
