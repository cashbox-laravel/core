<?php

/*
 * This file is part of the "cashier-provider/core" project.
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
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Events;

use CashierProvider\Core\Concerns\Validators;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

abstract class BaseEvent
{
    use InteractsWithSockets;

    use SerializesModels;

    use Validators;

    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $payment
     */
    public function __construct(
        public Model $payment
    ) {
        $this->validateModel($this->payment);
    }
}
