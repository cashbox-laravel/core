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

namespace CashierProvider\Core\Config\Payments;

use DragonCode\Support\Facades\Helpers\Arr;
use Spatie\LaravelData\Data;

class Map extends Data
{
    public array $drivers = [];

    public function getTypes(): array
    {
        return array_keys($this->drivers);
    }

    public function get($type): ?string
    {
        return Arr::get($this->drivers, $type);
    }
}
