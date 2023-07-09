<?php

declare(strict_types=1);

namespace Tests\Support\Hash;

use Tests\TestCase;
use CashierProvider\BankName\Auth\Support\Hash;

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
