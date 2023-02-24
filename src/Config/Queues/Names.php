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

namespace CashierProvider\Core\Config\Queues;

use DragonCode\Contracts\Cashier\Config\Queues\Names as Contract;
use DragonCode\SimpleDataTransferObject\DataTransferObject;

class Names extends DataTransferObject implements Contract
{
    protected ?string $start = null;

    protected ?string $check = null;

    protected ?string $refund = null;

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function getCheck(): ?string
    {
        return $this->check;
    }

    public function getRefund(): ?string
    {
        return $this->refund;
    }
}
