<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Jobs;

use CashierProvider\Core\Concerns\Permissions\Allowable;
use CashierProvider\Core\Data\Http\Response;

class VerifyJob extends BaseJob
{
    use Allowable;

    protected function request(): Response
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
