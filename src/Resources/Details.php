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

namespace CashierProvider\Core\Resources;

use CashierProvider\Core\Concerns\Jsonable;
use DragonCode\Contracts\Cashier\Resources\Details as DetailsContract;
use DragonCode\SimpleDataTransferObject\DataTransferObject;

abstract class Details extends DataTransferObject implements DetailsContract
{
    use Jsonable;

    protected $status;

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
