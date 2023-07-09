<?php

namespace Tests\Responses;

use CashierProvider\Core\Http\Response as BaseResponse;
use Helldar\Contracts\Cashier\Http\Response;
use Tests\TestCase;
use CashierProvider\BankName\Technology\Responses\Created;

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
            BaseResponse::KEY_STATUS => self::STATUS,
        ], $response->toArray());
    }

    protected function response(): Response
    {
        return Created::make([
            'TerminalKey' => $this->getTerminalKey(),

            'Amount'    => self::PAYMENT_SUM_FORMATTED,
            'OrderId'   => self::PAYMENT_ID,
            'Success'   => true,
            'Status'    => self::STATUS,
            'PaymentId' => self::PAYMENT_EXTERNAL_ID,
            'ErrorCode' => 0,
        ]);
    }
}
