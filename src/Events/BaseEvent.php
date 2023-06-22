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
use Illuminate\Database\Eloquent\Model;

abstract class BaseEvent
{
    use Validators;

    public function __construct(
        public Model $payment
    ) {
        $this->validateModel($this->payment);
    }
}
