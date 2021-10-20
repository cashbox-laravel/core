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

namespace CashierProvider\Core\Events;

use CashierProvider\Core\Concerns\Validators;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class BaseEvent
{
    use InteractsWithSockets;
    use SerializesModels;
    use Validators;

    /**
     * The payment model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $payment;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $payment
     */
    public function __construct(Model $payment)
    {
        $this->validateModel($payment);

        $this->payment = $payment;
    }
}
