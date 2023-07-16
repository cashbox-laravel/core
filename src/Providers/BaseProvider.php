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

namespace Cashbox\Core\Providers;

use Cashbox\Core\Concerns\Config\Payment\Payments;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use function class_exists;

abstract class BaseProvider extends BaseServiceProvider
{
    use Payments;

    protected function disabled(): bool
    {
        $class = $this->model();

        return empty($class) || ! class_exists($class);
    }

    protected function model(): ?string
    {
        return config('cashbox.payment.model');
    }
}
