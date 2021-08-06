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

namespace Helldar\Cashier\Helpers;

use Helldar\Support\Facades\Helpers\Arr;

class JSON
{
    /**
     * @param  mixed  $value
     *
     * @return string
     */
    public function encode($value): string
    {
        $data = Arr::toArray($value);

        return json_encode($data);
    }

    public function decode(?string $encoded): array
    {
        if (empty($encoded)) {
            return [];
        }

        return json_decode($encoded, true) ?: [];
    }
}
