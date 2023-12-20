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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Core\Data\Models;

use Cashbox\Core\Concerns\Config\Application;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class InfoData extends Data
{
    use Application;

    public Optional|string|null $externalId;

    public Optional|string|null $operationId;

    public Optional|string|null $status;

    public array|Optional $extra = [];

    public function toJson($options = 0): string
    {
        return parent::toJson($this->flags());
    }

    protected function flags(): int
    {
        return static::isProduction()
            ? JSON_UNESCAPED_SLASHES ^ JSON_UNESCAPED_UNICODE ^ JSON_NUMERIC_CHECK
            : JSON_UNESCAPED_SLASHES ^ JSON_UNESCAPED_UNICODE ^ JSON_NUMERIC_CHECK ^ JSON_PRETTY_PRINT;
    }
}
