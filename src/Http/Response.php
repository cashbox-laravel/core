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

namespace Cashbox\Core\Http;

use Cashbox\Core\Data\Models\InfoData;
use Spatie\LaravelData\Data;

abstract class Response extends Data
{
    public function getInfo(): InfoData
    {
        return InfoData::from([
            'externalId'  => $this->getExternalId(),
            'operationId' => $this->getOperationId(),
            'status'      => $this->getStatus(),
            'extra'       => $this->getExtra(),
        ]);
    }

    public function getOperationId(): ?string
    {
        return null;
    }

    public function getExternalId(): ?string
    {
        return null;
    }

    public function isEmpty(): bool
    {
        return empty($this->toArray());
    }

    protected function getExtra(): array
    {
        return [];
    }
}
