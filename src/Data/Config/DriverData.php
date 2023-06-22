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

namespace CashierProvider\Core\Data\Config;

use CashierProvider\Core\Data\Config\Drivers\CredentialsData;
use CashierProvider\Core\Data\Config\Queue\QueueNameData;
use CashierProvider\Core\Services\Driver as Service;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class DriverData extends Data
{
    public Service|string $driver;

    public string $details;

    public ?CredentialsData $credentials;

    public ?QueueNameData $queue;
}
