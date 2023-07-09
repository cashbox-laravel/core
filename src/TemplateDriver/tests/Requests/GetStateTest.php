<?php

namespace Tests\Requests;

use CashierProvider\Core\Http\Request;
use DragonCode\Contracts\Cashier\Http\Request as RequestContract;
use DragonCode\Contracts\Http\Builder;
use Tests\TestCase;
use CashierProvider\BankName\Technology\Requests\GetState;

class GetStateTest extends TestCase
{
    public function testInstance()
    {
        $request = $this->request(GetState::class);

        $this->assertInstanceOf(GetState::class, $request);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertInstanceOf(RequestContract::class, $request);
    }

    public function testUri()
    {
        $request = $this->request(GetState::class);

        $this->assertInstanceOf(Builder::class, $request->uri());

        $this->assertSame('https://dev.api-bank-uri.com/api/status', $request->uri()->toUrl());
    }

    public function testHeaders()
    {
        $request = $this->request(GetState::class);

        $this->assertIsArray($request->headers());

        $this->assertSame([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ], $request->headers());
    }

    public function testGetRawHeaders()
    {
        $request = $this->request(GetState::class);

        $this->assertIsArray($request->getRawHeaders());

        $this->assertSame([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ], $request->getRawHeaders());
    }

    public function testBody()
    {
        $request = $this->request(GetState::class);

        $this->assertIsArray($request->body());

        $this->assertSame([
            'PaymentId' => self::PAYMENT_EXTERNAL_ID,

            'TerminalKey' => $this->getTerminalKey(),

            'Token' => 'dbcbdf5539c35132b63c1b54e0f107cc96e71cf96040ba54dec5e140255b2e63',
        ], $request->body());
    }

    public function testGetRawBody()
    {
        $request = $this->request(GetState::class);

        $this->assertIsArray($request->getRawBody());

        $this->assertSame([
            'PaymentId' => self::PAYMENT_EXTERNAL_ID,
        ], $request->getRawBody());
    }
}
