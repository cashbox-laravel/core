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

namespace Tests;

use CashierProvider\Core\Http\Response;
use CashierProvider\Tinkoff\QrCode\Driver as QR;
use DragonCode\Contracts\Cashier\Driver as DriverContract;
use DragonCode\Contracts\Cashier\Http\Response as ResponseContract;
use DragonCode\Support\Facades\Http\Url;
use Tests\Fixtures\Models\RequestPayment;

class DriverTest extends TestCase
{
    protected $model = RequestPayment::class;

    protected function setUp(): void
    {
        parent::setUp();

        $this->runSeeders();
    }

    public function testStart()
    {
        $response = $this->driver()->start();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseContract::class, $response);

        $this->assertIsString($response->getExternalId());
        $this->assertMatchesRegularExpression('/^(\d+)$/', $response->getExternalId());

        $this->assertNull($response->getStatus());

        $this->assertTrue(Url::is($response->getUrl()));
    }

    public function testCheck()
    {
        $this->driver()->start();

        $response = $this->driver()->check();

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
        $this->driver()->start();

        $response = $this->driver()->refund();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseContract::class, $response);

        $this->assertIsString($response->getExternalId());
        $this->assertMatchesRegularExpression('/^(\d+)$/', $response->getExternalId());

        $this->assertSame('CANCELED', $response->getStatus());
    }

    protected function driver(): DriverContract
    {
        $model = $this->payment();

        $config = $this->config();

        return QR::make($config, $model);
    }

    protected function payment(): RequestPayment
    {
        return RequestPayment::firstOrFail();
    }
}
