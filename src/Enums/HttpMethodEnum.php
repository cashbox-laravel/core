<?php

declare(strict_types=1);

namespace Cashbox\Core\Enums;

enum HttpMethodEnum: string
{
    case post = 'POST';
    case get  = 'GET';
}
