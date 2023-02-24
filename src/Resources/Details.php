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

namespace CashierProvider\Core\Resources;

use DragonCode\Support\Facades\Helpers\Arr;
use Spatie\LaravelData\Data;

abstract class Details extends Data
{
    public ?string $status;

    public function toArray(): array
    {
        return [
            'status' => $this->status,
        ];
    }

    public function toJson($options = 0): string
    {
        return json_encode(Arr::filter($this->toArray()), $options);
    }
}
