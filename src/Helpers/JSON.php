<?php

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

    public function decode(string $encoded): array
    {
        return json_decode($encoded, true);
    }
}
