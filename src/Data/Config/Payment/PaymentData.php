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

namespace Cashbox\Core\Data\Config\Payment;

use Cashbox\Core\Billable;
use Cashbox\Core\Data\Casts\Instances\InstanceOfCast;
use Cashbox\Core\Exceptions\Internal\IncorrectModelException;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    #[WithCast(InstanceOfCast::class, needle: Billable::class, exception: IncorrectModelException::class)]
    public Model|string $model;

    public AttributeData $attribute;

    public StatusData $status;

    /** @var array<string, string> */
    public array $drivers;
}
