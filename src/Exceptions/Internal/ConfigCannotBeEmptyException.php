<?php

declare(strict_types=1);

namespace Cashbox\Core\Exceptions\Internal;

use Cashbox\Core\Exceptions\BaseException;

class ConfigCannotBeEmptyException extends BaseException
{
    protected string $reason = 'Error reading configuration. Check the existence of the "config/cashbox.php" file.';
}
