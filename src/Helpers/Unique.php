<?php

namespace Helldar\Cashier\Helpers;

use Ramsey\Uuid\Uuid;

final class Unique
{
    public function uid(): string
    {
        return md5(Uuid::uuid4());
    }
}
