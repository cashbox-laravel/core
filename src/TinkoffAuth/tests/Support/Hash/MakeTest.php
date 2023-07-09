<?php

/*
 * This file is part of the "cashier-provider/tinkoff-auth" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/cashier-provider/tinkoff-auth
 */

declare(strict_types=1);

namespace Tests\Support\Hash;

use CashierProvider\Tinkoff\Auth\Support\Hash;
use Tests\TestCase;

class MakeTest extends TestCase
{
    public function testMake()
    {
        $hash = Hash::make();

        $this->assertInstanceOf(Hash::class, $hash);
    }

    public function testConstruct()
    {
        $hash = new Hash();

        $this->assertInstanceOf(Hash::class, $hash);
    }
}
