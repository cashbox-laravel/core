<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace CashierProvider\Manager\Config;

use Helldar\Contracts\Cashier\Config\Details as DetailsContract;

class Details extends Base implements DetailsContract
{
    public function getTable(): string
    {
        return config('cashier.details.table', 'cashier_details');
    }
}
