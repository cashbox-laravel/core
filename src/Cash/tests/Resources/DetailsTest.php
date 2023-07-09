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

namespace Tests\Resources;

use CashierProvider\Cash\Resources\Details as BaseDetails;
use DragonCode\Contracts\Cashier\Resources\Details as DetailsContract;
use Tests\TestCase;

class DetailsTest extends TestCase
{
    protected $expected = [
        'status' => self::STATUS,
    ];

    public function testMake()
    {
        $details = $this->details();

        $this->assertInstanceOf(BaseDetails::class, $details);
        $this->assertInstanceOf(BaseDetails::class, $details);
        $this->assertInstanceOf(DetailsContract::class, $details);
    }

    public function testGetStatus()
    {
        $details = $this->details();

        $this->assertSame(self::STATUS, $details->getStatus());
    }

    public function testToArray()
    {
        $details = $this->details();

        $this->assertSame($this->expected, $details->toArray());
    }

    public function testToJson()
    {
        $details = $this->details();

        $this->assertJson($details->toJson());

        $this->assertSame(json_encode($this->expected), $details->toJson());
    }

    protected function details(): BaseDetails
    {
        return BaseDetails::make($this->expected);
    }
}
