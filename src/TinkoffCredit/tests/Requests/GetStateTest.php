<?php

namespace Tests\Requests;

use CashierProvider\Core\Http\Request;
use CashierProvider\Tinkoff\Credit\Requests\GetState;
use DragonCode\Contracts\Cashier\Http\Request as RequestContract;
use DragonCode\Contracts\Http\Builder;
use Lmc\HttpConstants\Header;
use Tests\TestCase;

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

        $id = self::PAYMENT_ID;

        $this->assertSame("https://forma.tinkoff.ru/api/partners/v2/orders/{$id}/info", $request->uri()->toUrl());
    }

    public function testHeaders()
    {
        $request = $this->request(GetState::class);

        $this->assertIsArray($request->headers());

        $this->assertSame([
            Header::ACCEPT       => 'application/json',
            Header::CONTENT_TYPE => 'application/json',
        ], $request->headers());
    }

    public function testGetRawHeaders()
    {
        $request = $this->request(GetState::class);

        $this->assertIsArray($request->getRawHeaders());

        $this->assertSame([
            Header::ACCEPT       => 'application/json',
            Header::CONTENT_TYPE => 'application/json',
        ], $request->getRawHeaders());
    }

    public function testBody()
    {
        $request = $this->request(GetState::class);

        $this->assertIsArray($request->body());
        $this->assertEmpty($request->body());
    }

    public function testGetRawBody()
    {
        $request = $this->request(GetState::class);

        $this->assertIsArray($request->getRawBody());
        $this->assertEmpty($request->body());
    }
}
