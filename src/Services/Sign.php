<?php

declare(strict_types=1);

namespace Cashbox\Core\Services;

use Cashbox\Core\Http\Request;

abstract class Sign
{
    public function __construct(
        protected readonly Request $request,
        protected readonly bool $secure = true
    ) {}

    public function headers(): array
    {
        return $this->request->headers();
    }

    public function options(): array
    {
        return $this->request->options();
    }

    public function body(): array
    {
        return $this->request->body();
    }
}
