<?php

namespace Tests\Responses;

use CashierProvider\Core\Http\Response as BaseResponse;
use CashierProvider\Tinkoff\Credit\Responses\Created;
use DragonCode\Contracts\Cashier\Http\Response;
use Tests\TestCase;

class InitTest extends TestCase
{
    public function testInstance()
    {
        $response = $this->response();

        $this->assertInstanceOf(Created::class, $response);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testGetExternalId()
    {
        $response = $this->response();

        $this->assertSame(self::PAYMENT_EXTERNAL_ID, $response->getExternalId());
    }

    public function testGetStatus()
    {
        $response = $this->response();

        $this->assertSame(self::STATUS, $response->getStatus());
    }

    public function testToArray()
    {
        $response = $this->response();

        $this->assertSame([
            Created::KEY_URL         => self::URL,
            BaseResponse::KEY_STATUS => self::STATUS,
        ], $response->toArray());
    }

    protected function response(): Response
    {
        return Created::make([
            'id'   => self::PAYMENT_EXTERNAL_ID,
            'link' => self::URL,
        ]);
    }
}
