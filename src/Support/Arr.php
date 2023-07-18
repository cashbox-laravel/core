<?php

declare(strict_types=1);

namespace Cashbox\Core\Support;

class Arr
{
    public static function filter(array $items): array
    {
        foreach ($items as $key => &$value) {
            if (is_array($value)) {
                $value = static::filter($value);
            }

            if ($value === null) {
                unset($items[$key]);
            }
        }

        return $items;
    }

    public static function merge(array $to, array $from): array
    {
        foreach ($from as $key => $value) {
            if (is_array($value)) {
                $to[$key] = static::merge($to[$key] ?? [], $value);

                continue;
            }

            if ($value !== null) {
                $to[$key] = $value;
            }
        }

        return $to;
    }
}
