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

namespace Cashbox\Core\Jobs;

use Cashbox\Core\Http\Response;

class RefundJob extends BaseJob
{
    protected function request(): Response
    {
        $this->verify();

        return $this->refund();
    }

    protected function verify(): void
    {
        dispatch_sync(new VerifyJob($this->payment, true));
    }

    protected function refund(): Response
    {
        return $this->driver()->refund();
    }
}
