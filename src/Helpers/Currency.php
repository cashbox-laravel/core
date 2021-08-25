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

use Helldar\Cashier\Resources\Currency as Resource;
use Helldar\Support\Concerns\Resolvable;
use Helldar\Support\Facades\Helpers\Str;
use Money\Currencies\ISOCurrencies;
use Money\Currency as CurrencyMoney;

class Currency
{
    use Resolvable;

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

        return $this->resource($currency);
    }

    protected function findByString(string $value): Resource
    {
        $currency = $this->money($value);

        $numeric = $this->iso()->numericCodeFor($currency);

        return $this->resource($numeric);
    }

    protected function money(string $value): CurrencyMoney
    {
        return new CurrencyMoney($value);
    }

    protected function iso(): ISOCurrencies
    {
        return self::resolveInstance(ISOCurrencies::class);
    }

    protected function prepare(string $currency): string
    {
        return Str::upper($currency);
    }

    protected function resource(int $numeric): Resource
    {
        return Resource::make(compact('numeric'));
    }
}
