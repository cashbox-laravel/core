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
    protected mixed $id;

    protected ?string $uuid;

    public function id(bool $unique = true): string
    {
        return $this->get($this->id, function () {
            return md5($this->uuid());
        }, $unique);
    }

    public function uuid(bool $unique = true): string
    {
        return $this->get($this->uuid, static function () {
            return Uuid::uuid4()->toString();
        }, $unique);
    }

    protected function get(?string &$attribute, callable $callback, bool $unique): string
    {
        if (! $unique && $attribute) {
            return $attribute;
        }

        return $attribute = $callback();
    }
}
