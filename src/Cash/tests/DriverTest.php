<?php

/*
 * This file is part of the "cashier-provider/cash" project.
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
 * @see https://github.com/cashier-provider/cash
 */

namespace Tests;

use CashierProvider\Cash\Driver as Technology;
use CashierProvider\Core\Http\Response;
use CashierProvider\Core\Services\Jobs;
use DragonCode\Contracts\Cashier\Driver as DriverContract;
use DragonCode\Contracts\Cashier\Http\Response as ResponseContract;
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

        $this->assertSame(self::STATUS, $response->getStatus());
    }

    public function testCheck()
    {
        $payment = $this->payment();

        Jobs::make($payment)->start();

        $response = $this->driver($payment)->check();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(ResponseContract::class, $response);

        $this->assertIsString($response->getExternalId());

        $this->assertSame(self::STATUS, $response->getStatus());

        $this->assertSame([
            'status' => self::STATUS,
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

        $this->assertSame('REFUNDED', $response->getStatus());
    }

    protected function driver(Model $payment): DriverContract
    {
        $config = $this->config();

        return Technology::make($config, $payment);
    }
}
