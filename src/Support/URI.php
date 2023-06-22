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

use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Http\Builder as HttpBuilder;
use DragonCode\Support\Http\Builder;

use function trim;

class URI
{
    use Makeable;

    protected string $uri;

    public function __construct(string $production, ?string $development, bool $isProduction = true)
    {
        $this->uri = ! $isProduction && ! empty($development) ? $development : $production;
    }

    public function getWithPath(?string $path): Builder
    {
        $builder = $this->parse();

        $path = $this->resolvePath($builder->getPath(), $path);

        return $builder->withPath($path);
    }

    protected function parse(): Builder
    {
        return HttpBuilder::parse($this->uri);
    }

    protected function resolvePath(?string ...$values): ?string
    {
        return Arr::of($values)
            ->filter()
            ->map(fn (string $value) => trim($value))
            ->implode(DIRECTORY_SEPARATOR)
            ->toString();
    }
}
