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
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Http;

use DragonCode\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

abstract class Request
{
    use Makeable;

    abstract public function body(): array;

    abstract public function headers(): array;

    abstract public function uri(): ?string;

    public function __construct(
        protected Model $payment
    ) {}

    public function options(): array
    {
        return [];
    }
}
