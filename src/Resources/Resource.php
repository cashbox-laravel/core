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

namespace Cashbox\Core\Resources;

use Cashbox\Core\Data\Config\DriverData;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Model|\Cashbox\Core\Billable $payment
 */
abstract class Resource
{
    abstract public function currency(): int;

    abstract public function sum(): int;

    public function __construct(
        public Model $payment,
        public DriverData $config
    ) {}

    public function paymentId(): string
    {
        return (string) $this->payment->getKey();
    }

    public function status(): mixed
    {
        return $this->payment->cashboxAttributeStatus();
    }
}
