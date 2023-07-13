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
 * @see https://github.com/cashbox/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Data\Config\Drivers\CredentialsData;
use CashierProvider\Core\Data\Config\Queue\QueueNameData;
use CashierProvider\Core\Facades\Config;
use Spatie\LaravelData\Data;

class DriverData extends Data
{
    public string $driver;

    public string $details;

    public ?CredentialsData $credentials;

    public ?QueueNameData $queue;

    public function getQueue(): QueueNameData
    {
        return $this->queue ?? Config::queue()->name;
    }
}
