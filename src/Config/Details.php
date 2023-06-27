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

namespace CashierProvider\Core\Config;

use DragonCode\Contracts\Cashier\Config\Details as DetailsContract;

class Details extends Base implements DetailsContract
{
    public function getTable(): string
    {
        return config('cashier.details.table', 'cashier_details');
    }
}
