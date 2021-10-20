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

namespace CashierProvider\Manager\Helpers;

use Illuminate\Support\Carbon;

class Date
{
    protected $format = 'Y-m-d\TH:i:s\Z';

    protected $timezone = 'UTC';

    public function toString(Carbon $date): string
    {
        return $date->clone()
            ->setTimezone($this->timezone)
            ->format($this->format);
    }
}
