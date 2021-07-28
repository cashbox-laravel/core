<?php

declare(strict_types=1);

namespace Helldar\Cashier\Exceptions\Runtime\Implement;

use Helldar\Cashier\Exceptions\Runtime\BaseException;

/** @method BaseImplementException __construct(string $class) */
abstract class BaseImplementException extends BaseException
{
    protected $reason = 'The %s class must implement %s';

    protected $needle;

    public function getReason(...$values): string
    {
        return parent::getReason($values[0], $this->needle);
    }
}
