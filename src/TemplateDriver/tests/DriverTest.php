<?php

namespace Tests;

use CashierProvider\Core\Http\Response;
use CashierProvider\Core\Services\Jobs;
use Helldar\Contracts\Cashier\Driver as DriverContract;
use Helldar\Contracts\Cashier\Http\Response as ResponseContract;
use Helldar\Support\Facades\Http\Url;
use Illuminate\Database\Eloquent\Model;
use Tests\Fixtures\Models\RequestPayment;
use CashierProvider\BankName\Technology\Driver as Technology;

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
        $this->assertMatchesRegularExpression('/^(\d+)$/', $response->getExternalId());

        $this->assertNull($response->getStatus());

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
        $this->assertMatchesRegularExpression('/^(\d+)$/', $response->getExternalId());

        $this->assertSame('FORM_SHOWED', $response->getStatus());

        $this->assertSame([
            'status' => 'FORM_SHOWED',
        ], $response->toArray());
    }

    public function testRefund()
    {
        $payment = $this->payment();

        Jobs::make($payment)->start();
        Jobs::make($payment)->check(true);

        $response = $this->driver($payment)->refund();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseContract::class, $response);

        $this->assertIsString($response->getExternalId());
        $this->assertMatchesRegularExpression('/^(\d+)$/', $response->getExternalId());

        $this->assertSame('CANCELED', $response->getStatus());
    }

    protected function driver(Model $payment): DriverContract
    {
        $config = $this->config();

        return Technology::make($config, $payment);
    }
}
