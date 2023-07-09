<?php

namespace Tests\Helpers;

use CashierProvider\Tinkoff\Credit\Helpers\Statuses;
use CashierProvider\Tinkoff\Credit\Resources\Details;
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

    public function testHasCreated()
    {
        $this->assertTrue($this->status('NEW')->hasCreated('NEW'));

        $this->assertFalse($this->status('CANCELED')->hasCreated('CANCELED'));

        $this->assertFalse($this->status('REJECTED')->hasCreated('REJECTED'));

        $this->assertFalse($this->status('APPROVED')->hasCreated('APPROVED'));

        $this->assertFalse($this->status('UNKNOWN')->hasCreated('UNKNOWN'));
    }

    public function testHasSuccess()
    {
        $this->assertFalse($this->status('NEW')->hasSuccess('NEW'));

        $this->assertFalse($this->status('CANCELED')->hasSuccess('CANCELED'));

        $this->assertFalse($this->status('REJECTED')->hasSuccess('REJECTED'));

        $this->assertTrue($this->status('APPROVED')->hasSuccess('APPROVED'));

        $this->assertFalse($this->status('UNKNOWN')->hasSuccess('UNKNOWN'));
    }

    public function testHasFailed()
    {
        $this->assertFalse($this->status('NEW')->hasFailed('NEW'));

        $this->assertFalse($this->status('CANCELED')->hasFailed('CANCELED'));

        $this->assertTrue($this->status('REJECTED')->hasFailed('REJECTED'));

        $this->assertFalse($this->status('APPROVED')->hasFailed('APPROVED'));

        $this->assertFalse($this->status('UNKNOWN')->hasFailed('UNKNOWN'));
    }

    public function testHasRefunding()
    {
        $this->assertFalse($this->status('NEW')->hasRefunding('NEW'));

        $this->assertFalse($this->status('CANCELED')->hasRefunding('CANCELED'));

        $this->assertFalse($this->status('REJECTED')->hasRefunding('REJECTED'));

        $this->assertFalse($this->status('APPROVED')->hasRefunding('APPROVED'));

        $this->assertFalse($this->status('UNKNOWN')->hasRefunding('UNKNOWN'));
    }

    public function testHasRefunded()
    {
        $this->assertFalse($this->status('NEW')->hasRefunded('NEW'));

        $this->assertTrue($this->status('CANCELED')->hasRefunded('CANCELED'));

        $this->assertFalse($this->status('REJECTED')->hasRefunded('REJECTED'));

        $this->assertFalse($this->status('APPROVED')->hasRefunded('APPROVED'));

        $this->assertFalse($this->status('UNKNOWN')->hasRefunded('UNKNOWN'));
    }

    public function testInProgress()
    {
        $this->assertTrue($this->status('NEW')->inProgress('NEW'));

        $this->assertFalse($this->status('CANCELED')->inProgress('CANCELED'));

        $this->assertFalse($this->status('REJECTED')->inProgress('REJECTED'));

        $this->assertFalse($this->status('APPROVED')->inProgress('APPROVED'));

        $this->assertTrue($this->status('UNKNOWN')->inProgress('UNKNOWN'));
    }

    protected function status(string $status): Statuses
    {
        $details = Details::make(compact('status'));

        return Statuses::make($this->model($details));
    }
}
