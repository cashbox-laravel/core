<?php

declare(strict_types=1);

namespace Tests\Resources\AccessToken;

use CashierProvider\BankName\Auth\Resources\AccessToken;
use Tests\TestCase;

class GetClientIdTest extends TestCase
{
    public function testBasic()
    {
        $token = AccessToken::make($this->credentials());

        $this->assertSame(self::TERMINAL_KEY, $token->getClientId());
    }

    public function testHashed()
    {
        $token = AccessToken::make($this->credentialsHash());

        $this->assertSame(self::TERMINAL_KEY, $token->getClientId());
    }
}
