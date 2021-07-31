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

use Ramsey\Uuid\Uuid;

class Unique
{
    protected $value;

    public function id(bool $unique = true): string
    {
        if (! $unique && $this->value) {
            return $this->value;
        }

        return $this->value = $this->hash();
    }

    protected function hash(): string
    {
        return md5($this->uuid());
    }

    protected function uuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
