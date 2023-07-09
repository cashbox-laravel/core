<?php

declare(strict_types=1);

namespace CashierProvider\Core\Support;

use DragonCode\Contracts\Http\Builder;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Http\Builder as HttpBuilder;

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
        return HttpBuilder::parse($this->uri);
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
