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

use Helldar\Contracts\Cashier\Config\Payments\Attributes as AttributesContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Attributes extends DataTransferObject implements AttributesContract
{
    protected $type;

    protected $status;

    protected $created_at;

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}
