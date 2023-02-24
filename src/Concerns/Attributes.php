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

namespace CashierProvider\Core\Concerns;

use CashierProvider\Core\Facades\Config\Payment;

trait Attributes
{
    public function attributeType(): string
    {
        return Payment::getAttributes()->type;
    }

    public function attributeStatus(): string
    {
        return Payment::getAttributes()->status;
    }

    public function attributeCreatedAt(): string
    {
        return Payment::getAttributes()->createdAt;
    }
}
