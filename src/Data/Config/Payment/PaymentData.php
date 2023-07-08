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

namespace CashierProvider\Core\Data\Config\Payment;

use CashierProvider\Core\Data\Casts\PaymentModelCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    #[WithCast(PaymentModelCast::class)]
    public Model|string $model;

    public AttributeData $attribute;

    public StatusData $status;

    /** @var \Illuminate\Support\Collection<string,array> */
    public Collection $drivers;
}
