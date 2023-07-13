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
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core\Concerns\Permissions;

use Cashbox\Core\Services\Authorize;

trait Allowable
{
    protected function authorizeType(): bool
    {
        return Authorize::type($this->payment);
    }

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
