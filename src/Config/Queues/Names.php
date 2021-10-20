<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace CashierProvider\Core\Config\Queues;

use Helldar\Contracts\Cashier\Config\Queues\Names as Contract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Names extends DataTransferObject implements Contract
{
    protected $start;

    protected $check;

    protected $refund;

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
