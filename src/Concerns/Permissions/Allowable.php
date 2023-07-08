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

namespace CashierProvider\Core\Concerns\Permissions;

use CashierProvider\Core\Helpers\Access;

trait Allowable
{
    protected function allowToStart(): bool
    {
        return Access::toStart($this->payment);
    }

    protected function allowToVerify(): bool
    {
        return Access::toVerify($this->payment);
    }

    protected function allowToRefund(): bool
    {
        return Access::toRefund($this->payment);
    }
}
