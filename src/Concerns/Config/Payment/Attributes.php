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
 * @see https://github.com/cashbox/foundation
 */

declare(strict_types=1);

namespace CashierProvider\Core\Concerns\Config\Payment;

use CashierProvider\Core\Data\Config\Payment\AttributeData;
use CashierProvider\Core\Facades\Config;

trait Attributes
{
    protected static function attribute(): AttributeData
    {
        return Config::payment()->attribute;
    }
}
