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

namespace CashierProvider\Core\Providers;

use CashierProvider\Core\Facades\Config;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use function class_exists;

abstract class BaseProvider extends BaseServiceProvider
{
    protected function disabled(): bool
    {
        return ! class_exists($this->model());
    }

    protected function model(): string
    {
        return Config::payment()->model;
    }
}
