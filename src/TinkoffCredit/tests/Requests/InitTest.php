<?php

namespace Tests\Requests;

use CashierProvider\Core\Http\Request;
use CashierProvider\Tinkoff\Credit\Requests\Init;
use DragonCode\Contracts\Cashier\Http\Request as RequestContract;
use DragonCode\Contracts\Http\Builder;
use Lmc\HttpConstants\Header;
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

        $this->assertSame('https://forma.tinkoff.ru/api/partners/v2/orders/create-demo', $request->uri()->toUrl());
    }

    public function testHeaders()
    {
        $request = $this->request(Init::class);

        $this->assertIsArray($request->headers());

        $this->assertSame([
            Header::ACCEPT       => 'application/json',
            Header::CONTENT_TYPE => 'application/json',
        ], $request->headers());
    }

    public function testGetRawHeaders()
    {
        $request = $this->request(Init::class);

        $this->assertIsArray($request->getRawHeaders());

        $this->assertSame([
            Header::ACCEPT       => 'application/json',
            Header::CONTENT_TYPE => 'application/json',
        ], $request->getRawHeaders());
    }

    public function testBody()
    {
        $request = $this->request(Init::class);

        $this->assertIsArray($request->body());

        $this->assertSame([
            'shopId'     => $this->getClientId(),
            'showcaseId' => $this->getShowCaseId(),
            'promoCode'  => $this->getPromoCode(),

            'sum' => (int) self::PAYMENT_SUM,

            'orderNumber' => self::PAYMENT_ID,

            'values' => [
                'contact' => [
                    'fio'         => [
                        'lastName'   => self::USER_LAST_NAME,
                        'firstName'  => self::USER_FIRST_NAME,
                        'middleName' => self::USER_MIDDLE_NAME,
                    ],
                    'mobilePhone' => self::USER_PHONE,
                    'email'       => self::USER_EMAIL,
                ],
            ],

            'items' => [
                [
                    'name'     => self::ORDER_ITEM_TITLE,
                    'quantity' => 1,
                    'price'    => (int) self::PAYMENT_SUM,
                ],
            ],
        ], $request->body());
    }

    public function testGetRawBody()
    {
        $request = $this->request(Init::class);

        $this->assertIsArray($request->getRawBody());

        $this->assertSame([
            'shopId'     => $this->getClientId(),
            'showcaseId' => $this->getShowCaseId(),
            'promoCode'  => $this->getPromoCode(),

            'sum' => (int) self::PAYMENT_SUM,

            'orderNumber' => self::PAYMENT_ID,

            'values' => [
                'contact' => [
                    'fio'         => [
                        'lastName'   => self::USER_LAST_NAME,
                        'firstName'  => self::USER_FIRST_NAME,
                        'middleName' => self::USER_MIDDLE_NAME,
                    ],
                    'mobilePhone' => self::USER_PHONE,
                    'email'       => self::USER_EMAIL,
                ],
            ],

            'items' => [
                [
                    'name'     => self::ORDER_ITEM_TITLE,
                    'quantity' => 1,
                    'price'    => (int) self::PAYMENT_SUM,
                ],
            ],
        ], $request->getRawBody());
    }
}
