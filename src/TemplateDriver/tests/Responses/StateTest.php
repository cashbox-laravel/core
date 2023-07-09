<?php

namespace Tests\Responses;

use CashierProvider\Core\Http\Response as BaseResponse;
use DragonCode\Contracts\Cashier\Http\Response;
use Tests\TestCase;
use CashierProvider\BankName\Technology\Responses\State;

class StateTest extends TestCase
{
    public function testInstance()
    {
        $response = $this->response();

        $this->assertInstanceOf(State::class, $response);
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
        return State::make([
            'TerminalKey' => $this->getTerminalKey(),

            'OrderId'   => self::PAYMENT_ID,
            'Success'   => true,
            'Status'    => self::STATUS,
            'PaymentId' => self::PAYMENT_EXTERNAL_ID,
            'ErrorCode' => 0,
        ]);
    }
}
