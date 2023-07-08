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

use CashierProvider\Core\Helpers\Authorize;

trait Allowable
{
    protected function authorizeToStart(): bool
    {
        return Authorize::toStart($this->payment);
    }

    protected function authorizeToVerify(): bool
    {
        return Authorize::toVerify($this->payment);
    }

    protected function authorizeToRefund(): bool
    {
        return Authorize::toRefund($this->payment);
    }
}
