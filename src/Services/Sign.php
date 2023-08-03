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

namespace Cashbox\Core\Services;

use Cashbox\Core\Data\Config\DriverData;
use Cashbox\Core\Http\Request;

abstract class Sign
{
    public function __construct(
        protected readonly Request $request,
        protected readonly DriverData $config,
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
