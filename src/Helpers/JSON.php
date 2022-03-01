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

namespace CashierProvider\Core\Helpers;

use DragonCode\Support\Facades\Helpers\Arr;

class JSON
{
    /**
     * @param mixed $value
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

        $decoded = json_decode($encoded, true) ?: [];

        return $this->doesntError() ? $decoded : $this->parseErrors($encoded);
    }

    protected function doesntError(): bool
    {
        return json_last_error() === JSON_ERROR_NONE;
    }

    protected function parseErrors(?string $encoded): array
    {
        return is_string($encoded) && ! empty($encoded) ? [$encoded] : [];
    }
}
