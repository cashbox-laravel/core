<?php

declare(strict_types=1);

namespace Tests\Resources\AccessToken;

use Helldar\Contracts\Cashier\Resources\AccessToken as AccessTokenContract;
use Tests\TestCase;
use CashierProvider\BankName\Auth\Resources\AccessToken;

class MakeTest extends TestCase
{
    public function testMake()
    {
        $token = AccessToken::make();

        $this->assertInstanceOf(AccessTokenContract::class, $token);
    }

    public function testConstruct()
    {
        $token = new AccessToken();

        $this->assertInstanceOf(AccessTokenContract::class, $token);
    }
}
