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

namespace CashierProvider\Core\Helpers;

use CashierProvider\Core\Concerns\Config\Payment\Attributes;
use CashierProvider\Core\Concerns\Config\Payment\Drivers;
use CashierProvider\Core\Concerns\Helpers\Validatable;
use CashierProvider\Core\Concerns\Transformers\EnumsTransformer;
use CashierProvider\Core\Data\Config\DriverData;
use CashierProvider\Core\Exceptions\Internal\UnknownDriverConfigException;
use CashierProvider\Core\Services\Driver;
use Illuminate\Database\Eloquent\Model;

class DriverManager
{
    use Attributes;
    use Drivers;
    use EnumsTransformer;
    use Validatable;

    public function __construct(
        protected Model $payment
    ) {
        $this->validateModel($this->payment);
    }

    public static function find(Model $payment): Driver
    {
        return (new static($payment))->get();
    }

    protected function get(): Driver
    {
        if ($data = $this->data()) {
            return call_user_func([$data->driver, 'make'], $data, $this->payment);
        }

        throw new UnknownDriverConfigException($this->type(), $this->payment->getKey());
    }

    protected function data(): ?DriverData
    {
        return static::drivers()->get(
            $this->type()
        );
    }

    protected function type(): string|int
    {
        $type = $this->payment->getAttribute(
            static::attribute()->type
        );

        return $this->transformFromEnum($type);
    }
}
