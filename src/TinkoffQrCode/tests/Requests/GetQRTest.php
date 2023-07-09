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
use CashierProvider\Tinkoff\QrCode\Requests\GetQR;
use Helldar\Contracts\Cashier\Http\Request as RequestContract;
use Helldar\Contracts\Http\Builder;
use Tests\TestCase;

class GetQRTest extends TestCase
{
    public function testInstance()
    {
        $request = $this->request(GetQR::class);

        $this->assertInstanceOf(GetQR::class, $request);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertInstanceOf(RequestContract::class, $request);
    }

    public function testUri()
    {
        $request = $this->request(GetQR::class);

        $this->assertInstanceOf(Builder::class, $request->uri());

        $this->assertSame('https://securepay.tinkoff.ru/v2/GetQr', $request->uri()->toUrl());
    }

    public function testHeaders()
    {
        $request = $this->request(GetQR::class);

        $this->assertIsArray($request->headers());

        $this->assertSame([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ], $request->headers());
    }

    public function testGetRawHeaders()
    {
        $request = $this->request(GetQR::class);

        $this->assertIsArray($request->getRawHeaders());

        $this->assertSame([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ], $request->getRawHeaders());
    }

    public function testBody()
    {
        $request = $this->request(GetQR::class);

        $this->assertIsArray($request->body());

        $this->assertSame([
            'PaymentId' => self::PAYMENT_EXTERNAL_ID,

            'TerminalKey' => $this->getTerminalKey(),

            'Token' => 'dbcbdf5539c35132b63c1b54e0f107cc96e71cf96040ba54dec5e140255b2e63',
        ], $request->body());
    }

    public function testGetRawBody()
    {
        $request = $this->request(GetQR::class);

        $this->assertIsArray($request->getRawBody());

        $this->assertSame([
            'PaymentId' => self::PAYMENT_EXTERNAL_ID,
        ], $request->getRawBody());
    }
}
