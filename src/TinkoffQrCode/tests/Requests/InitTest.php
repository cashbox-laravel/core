<?php

/*
 * This file is part of the "cashier-provider/tinkoff-qr" project.
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
 * @see https://github.com/cashier-provider/tinkoff-qr
 */

namespace Tests\Requests;

use CashierProvider\Core\Http\Request;
use CashierProvider\Tinkoff\QrCode\Requests\Init;
use DragonCode\Contracts\Cashier\Http\Request as RequestContract;
use DragonCode\Contracts\Http\Builder;
use Tests\TestCase;

class InitTest extends TestCase
{
    public function testInstance()
    {
        $request = $this->request(Init::class);

        $this->assertInstanceOf(Init::class, $request);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertInstanceOf(RequestContract::class, $request);
    }

    public function testUri()
    {
        $request = $this->request(Init::class);

        $this->assertInstanceOf(Builder::class, $request->uri());

        $this->assertSame('https://securepay.tinkoff.ru/v2/Init', $request->uri()->toUrl());
    }

    public function testHeaders()
    {
        $request = $this->request(Init::class);

        $this->assertIsArray($request->headers());

        $this->assertSame([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ], $request->headers());
    }

    public function testGetRawHeaders()
    {
        $request = $this->request(Init::class);

        $this->assertIsArray($request->getRawHeaders());

        $this->assertSame([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ], $request->getRawHeaders());
    }

    public function testBody()
    {
        $request = $this->request(Init::class);

        $this->assertIsArray($request->body());

        $this->assertSame([
            'OrderId'  => self::PAYMENT_ID,
            'Amount'   => self::PAYMENT_SUM_FORMATTED,
            'Currency' => self::CURRENCY_FORMATTED,

            'TerminalKey' => $this->getTerminalKey(),
            'Token'       => $this->getTerminalSecret(),
        ], $request->body());
    }

    public function testGetRawBody()
    {
        $request = $this->request(Init::class);

        $this->assertIsArray($request->getRawBody());

        $this->assertSame([
            'OrderId'  => self::PAYMENT_ID,
            'Amount'   => self::PAYMENT_SUM_FORMATTED,
            'Currency' => self::CURRENCY_FORMATTED,
        ], $request->getRawBody());
    }
}
