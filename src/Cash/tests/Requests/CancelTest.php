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

namespace Tests\Requests;

use CashierProvider\Cash\Requests\Cancel;
use CashierProvider\Core\Http\Request;
use DragonCode\Contracts\Cashier\Http\Request as RequestContract;
use Tests\TestCase;

class CancelTest extends TestCase
{
    public const STATUS = 'REFUNDED';

    public function testInstance()
    {
        $request = $this->request(Cancel::class);

        $this->assertInstanceOf(Cancel::class, $request);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertInstanceOf(RequestContract::class, $request);
    }

    public function testBody()
    {
        $request = $this->request(Cancel::class);

        $this->assertIsArray($request->body());

        $this->assertSame([
            'PaymentId' => self::PAYMENT_EXTERNAL_ID,
            'Status'    => self::STATUS,
        ], $request->body());
    }

    public function testGetRawBody()
    {
        $request = $this->request(Cancel::class);

        $this->assertIsArray($request->getRawBody());

        $this->assertSame([
            'PaymentId' => self::PAYMENT_EXTERNAL_ID,
            'Status'    => self::STATUS,
        ], $request->body());
    }
}
