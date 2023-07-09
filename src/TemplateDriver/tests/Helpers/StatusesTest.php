<?php

namespace Tests\Helpers;

use Tests\TestCase;
use CashierProvider\BankName\Technology\Helpers\Statuses;
use CashierProvider\BankName\Technology\Resources\Details;

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
        $this->assertTrue($this->status('FORM_SHOWED')->hasCreated('FORM_SHOWED'));
        $this->assertTrue($this->status('NEW')->hasCreated('NEW'));

        $this->assertFalse($this->status('AUTHORIZED')->hasCreated('AUTHORIZED'));
        $this->assertFalse($this->status('AUTHORIZING')->hasCreated('AUTHORIZING'));
        $this->assertFalse($this->status('CONFIRMING')->hasCreated('CONFIRMING'));

        $this->assertFalse($this->status('REFUNDING')->hasCreated('REFUNDING'));

        $this->assertFalse($this->status('PARTIAL_REFUNDED')->hasCreated('PARTIAL_REFUNDED'));
        $this->assertFalse($this->status('REFUNDED')->hasCreated('REFUNDED'));
        $this->assertFalse($this->status('REVERSED')->hasCreated('REVERSED'));

        $this->assertFalse($this->status('ATTEMPTS_EXPIRED')->hasCreated('ATTEMPTS_EXPIRED'));
        $this->assertFalse($this->status('CANCELED')->hasCreated('CANCELED'));
        $this->assertFalse($this->status('DEADLINE_EXPIRED')->hasCreated('DEADLINE_EXPIRED'));
        $this->assertFalse($this->status('REJECTED')->hasCreated('REJECTED'));

        $this->assertFalse($this->status('CONFIRMED')->hasCreated('CONFIRMED'));

        $this->assertFalse($this->status('UNKNOWN')->hasCreated('UNKNOWN'));
    }

    public function testHasSuccess()
    {
        $this->assertFalse($this->status('FORM_SHOWED')->hasSuccess('FORM_SHOWED'));
        $this->assertFalse($this->status('NEW')->hasSuccess('NEW'));

        $this->assertFalse($this->status('AUTHORIZED')->hasSuccess('AUTHORIZED'));
        $this->assertFalse($this->status('AUTHORIZING')->hasSuccess('AUTHORIZING'));
        $this->assertFalse($this->status('CONFIRMING')->hasSuccess('CONFIRMING'));

        $this->assertFalse($this->status('REFUNDING')->hasSuccess('REFUNDING'));

        $this->assertFalse($this->status('PARTIAL_REFUNDED')->hasSuccess('PARTIAL_REFUNDED'));
        $this->assertFalse($this->status('REFUNDED')->hasSuccess('REFUNDED'));
        $this->assertFalse($this->status('REVERSED')->hasSuccess('REVERSED'));

        $this->assertFalse($this->status('ATTEMPTS_EXPIRED')->hasSuccess('ATTEMPTS_EXPIRED'));
        $this->assertFalse($this->status('CANCELED')->hasSuccess('CANCELED'));
        $this->assertFalse($this->status('DEADLINE_EXPIRED')->hasSuccess('DEADLINE_EXPIRED'));
        $this->assertFalse($this->status('REJECTED')->hasSuccess('REJECTED'));

        $this->assertTrue($this->status('CONFIRMED')->hasSuccess('CONFIRMED'));

        $this->assertFalse($this->status('UNKNOWN')->hasSuccess('UNKNOWN'));
    }

    public function testHasFailed()
    {
        $this->assertFalse($this->status('FORM_SHOWED')->hasFailed('FORM_SHOWED'));
        $this->assertFalse($this->status('NEW')->hasFailed('NEW'));

        $this->assertFalse($this->status('AUTHORIZED')->hasFailed('AUTHORIZED'));
        $this->assertFalse($this->status('AUTHORIZING')->hasFailed('AUTHORIZING'));
        $this->assertFalse($this->status('CONFIRMING')->hasFailed('CONFIRMING'));

        $this->assertFalse($this->status('REFUNDING')->hasFailed('REFUNDING'));

        $this->assertFalse($this->status('PARTIAL_REFUNDED')->hasFailed('PARTIAL_REFUNDED'));
        $this->assertFalse($this->status('REFUNDED')->hasFailed('REFUNDED'));
        $this->assertFalse($this->status('REVERSED')->hasFailed('REVERSED'));

        $this->assertTrue($this->status('ATTEMPTS_EXPIRED')->hasFailed('ATTEMPTS_EXPIRED'));
        $this->assertTrue($this->status('CANCELED')->hasFailed('CANCELED'));
        $this->assertTrue($this->status('DEADLINE_EXPIRED')->hasFailed('DEADLINE_EXPIRED'));
        $this->assertTrue($this->status('REJECTED')->hasFailed('REJECTED'));

        $this->assertFalse($this->status('CONFIRMED')->hasFailed('CONFIRMED'));

        $this->assertFalse($this->status('UNKNOWN')->hasFailed('UNKNOWN'));
    }

    public function testHasRefunding()
    {
        $this->assertFalse($this->status('FORM_SHOWED')->hasRefunding('FORM_SHOWED'));
        $this->assertFalse($this->status('NEW')->hasRefunding('NEW'));

        $this->assertFalse($this->status('AUTHORIZED')->hasRefunding('AUTHORIZED'));
        $this->assertFalse($this->status('AUTHORIZING')->hasRefunding('AUTHORIZING'));
        $this->assertFalse($this->status('CONFIRMING')->hasRefunding('CONFIRMING'));

        $this->assertTrue($this->status('REFUNDING')->hasRefunding('REFUNDING'));

        $this->assertFalse($this->status('PARTIAL_REFUNDED')->hasRefunding('PARTIAL_REFUNDED'));
        $this->assertFalse($this->status('REFUNDED')->hasRefunding('REFUNDED'));
        $this->assertFalse($this->status('REVERSED')->hasRefunding('REVERSED'));

        $this->assertFalse($this->status('ATTEMPTS_EXPIRED')->hasRefunding('ATTEMPTS_EXPIRED'));
        $this->assertFalse($this->status('CANCELED')->hasRefunding('CANCELED'));
        $this->assertFalse($this->status('DEADLINE_EXPIRED')->hasRefunding('DEADLINE_EXPIRED'));
        $this->assertFalse($this->status('REJECTED')->hasRefunding('REJECTED'));

        $this->assertFalse($this->status('CONFIRMED')->hasRefunding('CONFIRMED'));

        $this->assertFalse($this->status('UNKNOWN')->hasRefunding('UNKNOWN'));
    }

    public function testHasRefunded()
    {
        $this->assertFalse($this->status('FORM_SHOWED')->hasRefunded('FORM_SHOWED'));
        $this->assertFalse($this->status('NEW')->hasRefunded('NEW'));

        $this->assertFalse($this->status('AUTHORIZED')->hasRefunded('AUTHORIZED'));
        $this->assertFalse($this->status('AUTHORIZING')->hasRefunded('AUTHORIZING'));
        $this->assertFalse($this->status('CONFIRMING')->hasRefunded('CONFIRMING'));

        $this->assertFalse($this->status('REFUNDING')->hasRefunded('REFUNDING'));

        $this->assertTrue($this->status('PARTIAL_REFUNDED')->hasRefunded('PARTIAL_REFUNDED'));
        $this->assertTrue($this->status('REFUNDED')->hasRefunded('REFUNDED'));
        $this->assertTrue($this->status('REVERSED')->hasRefunded('REVERSED'));

        $this->assertFalse($this->status('ATTEMPTS_EXPIRED')->hasRefunded('ATTEMPTS_EXPIRED'));
        $this->assertFalse($this->status('CANCELED')->hasRefunded('CANCELED'));
        $this->assertFalse($this->status('DEADLINE_EXPIRED')->hasRefunded('DEADLINE_EXPIRED'));
        $this->assertFalse($this->status('REJECTED')->hasRefunded('REJECTED'));

        $this->assertFalse($this->status('CONFIRMED')->hasRefunded('CONFIRMED'));

        $this->assertFalse($this->status('UNKNOWN')->hasRefunded('UNKNOWN'));
    }

    public function testInProgress()
    {
        $this->assertTrue($this->status('FORM_SHOWED')->inProgress('FORM_SHOWED'));
        $this->assertTrue($this->status('NEW')->inProgress('NEW'));

        $this->assertTrue($this->status('AUTHORIZED')->inProgress('AUTHORIZED'));
        $this->assertTrue($this->status('AUTHORIZING')->inProgress('AUTHORIZING'));
        $this->assertTrue($this->status('CONFIRMING')->inProgress('CONFIRMING'));

        $this->assertTrue($this->status('REFUNDING')->inProgress('REFUNDING'));

        $this->assertFalse($this->status('PARTIAL_REFUNDED')->inProgress('PARTIAL_REFUNDED'));
        $this->assertFalse($this->status('REFUNDED')->inProgress('REFUNDED'));
        $this->assertFalse($this->status('REVERSED')->inProgress('REVERSED'));

        $this->assertFalse($this->status('ATTEMPTS_EXPIRED')->inProgress('ATTEMPTS_EXPIRED'));
        $this->assertFalse($this->status('CANCELED')->inProgress('CANCELED'));
        $this->assertFalse($this->status('DEADLINE_EXPIRED')->inProgress('DEADLINE_EXPIRED'));
        $this->assertFalse($this->status('REJECTED')->inProgress('REJECTED'));

        $this->assertFalse($this->status('CONFIRMED')->inProgress('CONFIRMED'));

        $this->assertTrue($this->status('UNKNOWN')->inProgress('UNKNOWN'));
    }

    protected function status(string $status): Statuses
    {
        $details = Details::make(compact('status'));

        return Statuses::make($this->model($details));
    }
}
