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

use DragonCode\Contracts\Cashier\Config\Payments\Statuses as StatusesContract;
use DragonCode\SimpleDataTransferObject\DataTransferObject;
use DragonCode\Support\Facades\Helpers\Arr;

class Statuses extends DataTransferObject implements StatusesContract
{
    protected $statuses = [];

    public function getAll(): array
    {
        return $this->statuses;
    }

    public function getStatus(string $status)
    {
        return Arr::get($this->getAll(), $status);
    }
}
