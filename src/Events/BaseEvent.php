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
     */
    public function __construct(Model $payment)
    {
        $this->validateModel($payment);

        $this->payment = $payment;
    }
}
