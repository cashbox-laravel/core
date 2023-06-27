<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Support;

use DragonCode\Contracts\Http\Builder;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Http\Url;

class URI
{
    use Makeable;

    /** @var string */
    protected $uri;

    public function __construct(string $production, ?string $development, bool $is_production = true)
    {
        $this->uri = ! $is_production && ! empty($development) ? $development : $production;
    }

    public function getWithPath(?string $path): Builder
    {
        $builder = $this->parse();

        $path = $this->resolvePath($builder->getPath(), $path);

        return $builder->withPath($path);
    }

    protected function parse(): Builder
    {
        return Url::parse($this->uri);
    }

    protected function resolvePath(?string ...$values): ?string
    {
        $path = [];

        foreach ($values as $value) {
            if (! empty($value)) {
                $path[] = trim($value, '/');
            }
        }

        return implode('/', $path);
    }
}
