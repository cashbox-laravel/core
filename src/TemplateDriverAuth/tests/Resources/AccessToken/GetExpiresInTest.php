<?php

declare(strict_types=1);

namespace Tests\Resources\AccessToken;

use Carbon\Carbon as BaseCarbon;
use CashierProvider\BankName\Auth\Resources\AccessToken;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class GetExpiresInTest extends TestCase
{
    public function testBasic()
    {
        $token = AccessToken::make($this->credentials());

        $this->assertInstanceOf(Carbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(BaseCarbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(DateTimeInterface::class, $token->getExpiresIn());

        $this->assertGreaterThan(Carbon::now(), $token->getExpiresIn());
    }

    public function testHashed()
    {
        $token = AccessToken::make($this->credentialsHash());

        $this->assertInstanceOf(Carbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(BaseCarbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(DateTimeInterface::class, $token->getExpiresIn());

        $this->assertGreaterThan(Carbon::now(), $token->getExpiresIn());
    }
}
