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
use CashierProvider\Core\Facades\Config\Main as MainConfig;
use Spatie\LaravelData\Data;

class Driver extends Data
{
    public string $driver;

    public string $details;

    public ?string $client_id;

    public ?string $client_secret;

    public ?string $queue;

    public function getQueue(): Names
    {
        if ($this->queue) {
            return Names::from([
                'start'  => $this->queue,
                'check'  => $this->queue,
                'refund' => $this->queue,
            ]);
        }

        return MainConfig::getQueue()->names;
    }
}
