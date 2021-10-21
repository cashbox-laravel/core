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

use Ramsey\Uuid\Uuid;

class Unique
{
    protected $value;

    public function id(bool $unique = true): string
    {
        $value = md5($this->uuid());

        return $this->get($value, $unique);
    }

    public function uuid(bool $unique = true): string
    {
        $value = Uuid::uuid4()->toString();

        return $this->get($value, $unique);
    }

    protected function get(string $value, bool $unique): string
    {
        if (! $unique && $this->value) {
            return $this->value;
        }

        return $this->value = $value;
    }
}
