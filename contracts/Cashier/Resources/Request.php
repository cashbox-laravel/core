<?php

declare(strict_types=1);

namespace Helldar\Contracts\Cashier\Resources;

use Helldar\Contracts\Http\Builder;

/**
 * @method static Request make(Model $model)
 */
interface Request
{
    public function __construct(Model $model);

    public function uri(): Builder;

    public function headers(): array;

    public function body(): array;
}