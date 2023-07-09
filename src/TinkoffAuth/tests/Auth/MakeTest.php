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

namespace Tests\Auth;

use CashierProvider\Tinkoff\Auth\Auth;
use Helldar\Contracts\Cashier\Auth\Auth as AuthContract;
use Tests\TestCase;

class MakeTest extends TestCase
{
    public function testMakeBasic()
    {
        $auth = Auth::make($this->model(), $this->request(), false);

        $this->assertInstanceOf(AuthContract::class, $auth);
    }

    public function testMakeHash()
    {
        $auth = Auth::make($this->model(), $this->request());

        $this->assertInstanceOf(AuthContract::class, $auth);
    }

    public function testConstructBasic()
    {
        $auth = new Auth($this->model(), $this->request(), false);

        $this->assertInstanceOf(AuthContract::class, $auth);
    }

    public function testConstructHash()
    {
        $auth = new Auth($this->model(), $this->request());

        $this->assertInstanceOf(AuthContract::class, $auth);
    }
}
