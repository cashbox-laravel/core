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

namespace Helldar\Cashier\Events;

use Helldar\Cashier\Models\CashierDetail;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

abstract class BaseEvent
{
    use InteractsWithSockets;
    use SerializesModels;

    /** @var \Illuminate\Database\Eloquent\Model */
    public $payment;

    public function __construct(CashierDetail $detail)
    {
        $this->payment = $detail->parent;
    }
}
