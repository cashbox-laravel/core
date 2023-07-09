<?php

declare(strict_types=1);

namespace Tests\Auth;

use CashierProvider\BankName\Auth\Auth;
use Tests\TestCase;

class BodyTest extends TestCase
{
    public const TOKEN_HASH = '714bee21f51693eb5effb1895560f2a50dac0e795d5859a06b94bbdbe26faa1d';

    public function testBasic()
    {
        $auth = Auth::make($this->model(), $this->request(), false);

        $this->assertIsArray($auth->body());

        $this->assertSame([
            'PaymentId'   => self::PAYMENT_ID,
            'Sum'         => self::SUM_RESULT,
            'Currency'    => self::CURRENCY_RESULT,
            'CreatedAt'   => self::CREATED_AT_RESULT,
            'TerminalKey' => self::TERMINAL_KEY,
            'Token'       => self::TOKEN,
        ], $auth->body());
    }

    public function testHash()
    {
        $auth = Auth::make($this->model(), $this->request());

        $this->assertIsArray($auth->body());

        $this->assertSame([
            'PaymentId'   => self::PAYMENT_ID,
            'Sum'         => self::SUM_RESULT,
            'Currency'    => self::CURRENCY_RESULT,
            'CreatedAt'   => self::CREATED_AT_RESULT,
            'TerminalKey' => self::TERMINAL_KEY,
            'Token'       => self::TOKEN_HASH,
        ], $auth->body());
    }
}
