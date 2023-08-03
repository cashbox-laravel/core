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

namespace Cashbox\Core\Concerns\Permissions;

use Cashbox\Core\Services\Authorize;
use Illuminate\Database\Eloquent\Model;

trait Allowable
{
    protected function authorizeType(?Model $payment = null): bool
    {
        return Authorize::type(
            $payment ?? $this->payment
        );
    }

    protected function authorizeToStart(?Model $payment = null): bool
    {
        return Authorize::toStart(
            $payment ?? $this->payment
        );
    }

    protected function authorizeToVerify(?Model $payment = null): bool
    {
        return Authorize::toVerify(
            $payment ?? $this->payment
        );
    }

    protected function authorizeToRefund(?Model $payment = null): bool
    {
        return Authorize::toRefund(
            $payment ?? $this->payment
        );
    }
}
