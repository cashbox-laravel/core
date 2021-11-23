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

use CashierProvider\Core\Constants\Currency as CurrencyConstants;
use CashierProvider\Core\Exceptions\Runtime\UnknownCurrencyCodeException;
use CashierProvider\Core\Resources\Currency as Resource;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Reflection;
use DragonCode\Support\Facades\Helpers\Str;

class Currency
{
    /**
     * Get the currency resource instance.
     *
     * @param  int|string  $currency
     *
     * @return \CashierProvider\Core\Resources\Currency
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
            $code = Arr::get($items, $value);

            return $this->resource($code, $value);
        }

        throw new UnknownCurrencyCodeException($value);
    }

    protected function findByNumeric(int $code): Resource
    {
        $items = $this->all();

        if ($value = array_search($code, $items, true)) {
            return $this->resource($code, $value);
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
