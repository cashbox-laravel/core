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

namespace CashierProvider\Core\Config;

use CashierProvider\Core\Config\Queues\Names;
use Spatie\LaravelData\Data;

class Queue extends Data
{
    public ?string $connection;

    public Names $names;

    public bool $after_commit = true;

    public int $tries = 5;

    public array $unique = [];

    public function getTries(): int
    {
        $value = abs($this->tries);

        return $value > 0 ? $value : 5;
    }
}
