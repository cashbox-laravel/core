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

namespace Cashbox\Core\Data\Config;

use Cashbox\Core\Data\Casts\Instances\InstanceOfCast;
use Cashbox\Core\Data\Config\Drivers\CredentialsData;
use Cashbox\Core\Data\Config\Queue\QueueNameData;
use Cashbox\Core\Exceptions\Internal\IncorrectDriverException;
use Cashbox\Core\Exceptions\Internal\IncorrectResourceException;
use Cashbox\Core\Facades\Config;
use Cashbox\Core\Resources\Resource;
use Cashbox\Core\Services\Driver;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class DriverData extends Data
{
    #[WithCast(InstanceOfCast::class, needle: Driver::class, exception: IncorrectDriverException::class)]
    public string $driver;

    #[WithCast(InstanceOfCast::class, needle: Resource::class, exception: IncorrectResourceException::class)]
    public string $resource;

    public ?CredentialsData $credentials;

    public ?QueueNameData $queue;

    public function getQueue(): QueueNameData
    {
        return $this->queue ?? Config::queue()->name;
    }
}
