<?php

declare(strict_types=1);

namespace Tests\Auth;

use CashierProvider\BankName\Auth\Auth;
use DragonCode\Contracts\Cashier\Auth\Auth as AuthContract;
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
