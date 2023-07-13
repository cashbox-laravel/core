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

namespace Cashbox\Core\Jobs;

use Cashbox\Core\Concerns\Permissions\Allowable;
use Cashbox\Core\Http\ResponseInfo;

class VerifyJob extends BaseJob
{
    use Allowable;

    protected function request(): ResponseInfo
    {
        $this->start();

        return $this->driver()->verify();
    }

    protected function start(): void
    {
        if ($this->authorizeToStart()) {
            dispatch_sync(new StartJob($this->payment, true));
        }
    }
}
