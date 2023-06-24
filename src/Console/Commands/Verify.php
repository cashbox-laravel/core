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

namespace CashierProvider\Core\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('cashier:verify')]
class Verify extends Base
{
    protected $signature = 'cashier:verify';

    protected $description = 'Verifies the status of a bank transaction';
}
