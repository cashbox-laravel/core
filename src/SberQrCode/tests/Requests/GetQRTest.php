<?php

/*
 * This file is part of the "cashier-provider/sber-qr" project.
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
 * @see https://github.com/cashier-provider/sber-qr
 */

namespace Tests\Requests;

use CashierProvider\Core\Http\Request;
use CashierProvider\Sber\QrCode\Constants\Body;
use CashierProvider\Sber\QrCode\Requests\Create;
use DragonCode\Contracts\Cashier\Http\Request as RequestContract;
use DragonCode\Contracts\Http\Builder;
use DragonCode\Support\Facades\Helpers\Arr;
use Tests\TestCase;

class GetQRTest extends TestCase
{
    public function testInstance()
    {
        $request = $this->request(Create::class);

        $this->assertInstanceOf(Create::class, $request);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertInstanceOf(RequestContract::class, $request);
    }

    public function testUri()
    {
        $request = $this->request(Create::class);

        $this->assertInstanceOf(Builder::class, $request->uri());

        $this->assertSame('https://dev.api.sberbank.ru/ru/prod/order/v1/creation', $request->uri()->toUrl());
    }

    public function testHeaders()
    {
        $request = $this->request(Create::class);

        $headers = $request->headers();

        $this->assertIsArray($headers);

        $this->assertArrayHasKey('Accept', $headers);
        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertArrayHasKey('X-IBM-Client-Id', $headers);
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertArrayHasKey('x-Introspect-RqUID', $headers);

        $this->assertSame('application/json', Arr::get($headers, 'Accept'));
        $this->assertSame('application/json', Arr::get($headers, 'Content-Type'));

        $this->assertSame($this->getClientId(), Arr::get($headers, 'X-IBM-Client-Id'));
    }

    public function testGetRawHeaders()
    {
        $request = $this->request(Create::class);

        $this->assertIsArray($request->getRawHeaders());

        $this->assertSame([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ], $request->getRawHeaders());
    }

    public function testBody()
    {
        $request = $this->request(Create::class);

        $body = $request->body();

        $this->assertIsArray($body);

        $this->assertArrayHasKey(Body::REQUEST_ID, $body);
        $this->assertArrayHasKey(Body::REQUEST_TIME, $body);

        $this->assertArrayHasKey(Body::MEMBER_ID, $body);
        $this->assertArrayHasKey(Body::TERMINAL_ID, $body);

        $this->assertArrayHasKey(Body::ORDER_ID, $body);
        $this->assertArrayHasKey(Body::ORDER_SUM, $body);
        $this->assertArrayHasKey(Body::ORDER_CURRENCY, $body);
        $this->assertArrayHasKey(Body::ORDER_CREATED_AT, $body);
    }

    public function testGetRawBody()
    {
        $request = $this->request(Create::class);

        $body = $request->getRawBody();

        $this->assertIsArray($body);

        $this->assertArrayHasKey(Body::REQUEST_ID, $body);
        $this->assertArrayHasKey(Body::REQUEST_TIME, $body);

        $this->assertArrayHasKey(Body::MEMBER_ID, $body);
        $this->assertArrayHasKey(Body::TERMINAL_ID, $body);

        $this->assertArrayHasKey(Body::ORDER_ID, $body);
        $this->assertArrayHasKey(Body::ORDER_SUM, $body);
        $this->assertArrayHasKey(Body::ORDER_CURRENCY, $body);
        $this->assertArrayHasKey(Body::ORDER_CREATED_AT, $body);
    }
}
