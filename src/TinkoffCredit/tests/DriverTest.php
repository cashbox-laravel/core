<?php

namespace Tests;

use CashierProvider\Core\Http\Response;
use CashierProvider\Core\Services\Jobs;
use CashierProvider\Tinkoff\Credit\Driver as Credit;
use CashierProvider\Tinkoff\Credit\Exceptions\Http\CancelDeniedException;
use DragonCode\Contracts\Cashier\Driver as DriverContract;
use DragonCode\Contracts\Cashier\Http\Response as ResponseContract;
use DragonCode\Support\Facades\Http\Url;
use Illuminate\Database\Eloquent\Model;
use Tests\Fixtures\Models\RequestPayment;

class DriverTest extends TestCase
{
    protected $model = RequestPayment::class;

    public function testStart()
    {
        $payment = $this->payment();

        $response = $this->driver($payment)->start();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseContract::class, $response);

        $this->assertIsString($response->getExternalId());
        $this->assertMatchesRegularExpression('/^demo-\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b$/', $response->getExternalId());

        $this->assertSame(self::STATUS, $response->getStatus());

        $this->assertTrue(Url::is($response->getUrl()));
    }

    public function testCheck()
    {
        $payment = $this->payment();

        Jobs::make($payment)->start();

        $response = $this->driver($payment)->check();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseContract::class, $response);

        $this->assertIsString($response->getExternalId());
        $this->assertMatchesRegularExpression('/^\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b$/', $response->getExternalId());

        $this->assertSame('new', $response->getStatus());

        $this->assertSame([
            'status' => 'new',
        ], $response->toArray());
    }

    public function testRefund()
    {
        $this->expectException(CancelDeniedException::class);
        $this->expectExceptionMessage('Запрещено отменять эту заявку');

        $payment = $this->payment();

        Jobs::make($payment)->start();
        Jobs::make($payment)->check(true);

        $this->driver($payment)->refund();
    }

    protected function driver(Model $payment): DriverContract
    {
        $config = $this->config();

        return Credit::make($config, $payment);
    }
}
