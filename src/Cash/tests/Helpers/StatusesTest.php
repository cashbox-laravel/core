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

namespace Tests\Helpers;

use CashierProvider\Cash\Helpers\Statuses;
use CashierProvider\Cash\Resources\Details;
use Tests\TestCase;

class StatusesTest extends TestCase
{
    public function testModel()
    {
        $this->assertTrue($this->status('NEW')->hasCreated());
        $this->assertTrue($this->status('NEW')->inProgress());

        $this->assertFalse($this->status('NEW')->hasSuccess());
        $this->assertFalse($this->status('NEW')->hasFailed());
        $this->assertFalse($this->status('NEW')->hasRefunding());
        $this->assertFalse($this->status('NEW')->hasRefunded());
    }

    public function testHasSuccess()
    {
        $this->assertTrue($this->status('PAID')->hasSuccess('PAID'));
        $this->assertFalse($this->status('PAID')->hasSuccess('REFUNDED'));

        $this->assertTrue($this->status('REFUNDED')->hasSuccess('PAID'));
        $this->assertFalse($this->status('REFUNDED')->hasSuccess('REFUNDED'));

        $this->assertFalse($this->status('UNKNOWN')->hasSuccess('UNKNOWN'));
    }

    public function testHasRefunded()
    {
        $this->assertFalse($this->status('PAID')->hasRefunded('PAID'));
        $this->assertTrue($this->status('PAID')->hasRefunded('REFUNDED'));

        $this->assertFalse($this->status('REFUNDED')->hasRefunded('PAID'));
        $this->assertTrue($this->status('REFUNDED')->hasRefunded('REFUNDED'));

        $this->assertFalse($this->status('UNKNOWN')->hasRefunded('UNKNOWN'));
    }

    public function testInProgress()
    {
        $this->assertFalse($this->status('PAID')->inProgress('PAID'));
        $this->assertFalse($this->status('PAID')->inProgress('REFUNDED'));

        $this->assertFalse($this->status('REFUNDED')->inProgress('PAID'));
        $this->assertFalse($this->status('REFUNDED')->inProgress('REFUNDED'));

        $this->assertTrue($this->status('UNKNOWN')->inProgress('UNKNOWN'));
    }

    protected function status(string $status): Statuses
    {
        $details = Details::make(compact('status'));

        return Statuses::make($this->model($details));
    }
}
