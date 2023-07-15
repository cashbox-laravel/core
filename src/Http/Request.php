<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core\Http;

use Cashbox\Core\Resources\Resource;
use DragonCode\Support\Concerns\Makeable;

abstract class Request
{
    use Makeable;

    abstract public function body(): array;

    abstract public function uri(): ?string;

    public function __construct(
        protected Resource $resource
    ) {}

    public function headers(): array
    {
        return [];
    }

    public function options(): array
    {
        return [];
    }
}
