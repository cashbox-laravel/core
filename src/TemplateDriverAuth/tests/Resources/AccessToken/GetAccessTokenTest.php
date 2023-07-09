<?php

declare(strict_types=1);

namespace Tests\Resources\AccessToken;

use Tests\TestCase;
use CashierProvider\BankName\Auth\Resources\AccessToken;

class GetAccessTokenTest extends TestCase
{
    public function testBasic()
    {
        $token = AccessToken::make($this->credentials());

        $this->assertSame(self::TOKEN, $token->getAccessToken());
    }

    public function testHashed()
    {
        $token = AccessToken::make($this->credentialsHash());

        $this->assertSame(self::TOKEN_HASH, $token->getAccessToken());
    }
}
