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

namespace Cashbox\Core\Providers;

use Cashbox\Core\Data\Config\ConfigData;
use Cashbox\Core\Exceptions\Internal\ConfigCannotBeEmptyException;

class BindingServiceProvider extends BaseProvider
{
    public function boot(): void
    {
        if ($this->disabled()) {
            return;
        }

        $this->bindConfig();
    }

    protected function bindConfig(): void
    {
        $this->app->singleton(ConfigData::class, function () {
            if (! file_exists(config_path('cashbox.php'))) {
                return ConfigData::from(config('cashbox'));
            }

            throw new ConfigCannotBeEmptyException();
        });
    }
}
