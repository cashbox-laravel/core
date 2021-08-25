<?php

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
