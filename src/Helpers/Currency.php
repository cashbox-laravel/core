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

use Helldar\Cashier\Constants\Currency as CurrencyConstants;
use Helldar\Cashier\Exceptions\Runtime\UnknownCurrencyCodeException;
use Helldar\Cashier\Resources\Currency as Resource;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Reflection;
use Helldar\Support\Facades\Helpers\Str;

class Currency
{
    /**
     * Get the currency resource instance.
     *
     * @param  int|string  $currency
     *
     * @return \Helldar\Cashier\Resources\Currency
     */
    public function get($currency): Resource
    {
        if (is_string($currency)) {
            $value = $this->prepare($currency);

            return $this->findByString($value);
        }

        return $this->findByNumeric($currency);
    }

    /**
     * Get the available currencies list.
     *
     * @return array
     */
    public function all(): array
    {
        return Reflection::getConstants(CurrencyConstants::class);
    }

    protected function findByString(string $value): Resource
    {
        $items = $this->all();

        if (array_key_exists($value, $items)) {
            return Arr::get($items, $value);
        }

        throw new UnknownCurrencyCodeException($value);
    }

    protected function findByNumeric(int $value): Resource
    {
        $items = $this->all();

        if ($key = array_search($value, $items, true)) {
            return Arr::get($items, $key);
        }

        throw new UnknownCurrencyCodeException($value);
    }

    protected function prepare(string $currency): string
    {
        return Str::upper($currency);
    }

    protected function resource(int $numeric, string $alphabetic): Resource
    {
        return Resource::make(compact('numeric', 'alphabetic'));
    }
}
