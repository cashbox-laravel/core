<?php

/*
 * This file is part of the "cashier-provider/sber-qr" project.
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
 * @see https://github.com/cashier-provider/sber-qr
 */

namespace Tests\Helpers;

use CashierProvider\Sber\QrCode\Helpers\Statuses;
use CashierProvider\Sber\QrCode\Resources\Details;
use Tests\Fixtures\Models\StatusPayment;
use Tests\TestCase;

class StatusesTest extends TestCase
{
    protected $model = StatusPayment::class;

    public function testHasCreated()
    {
        $this->assertTrue($this->status('CREATED')->hasCreated());

        $this->assertFalse($this->status('REVERSED', 3)->hasCreated());
        $this->assertFalse($this->status('REFUNDED', 3)->hasCreated());
        $this->assertFalse($this->status('REVOKED', 3)->hasCreated());

        $this->assertFalse($this->status('PAID', 1)->hasCreated());

        $this->assertFalse($this->status('UNKNOWN', 7)->hasCreated());

        $this->assertTrue($this->status('UNKNOWN', 7)->hasCreated('CREATED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasCreated('REVERSED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->hasCreated('REFUNDED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->hasCreated('REVOKED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasCreated('PAID'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasCreated('UNKNOWN'));
    }

    public function testHasSuccess()
    {
        $this->assertFalse($this->status('CREATED')->hasSuccess());

        $this->assertFalse($this->status('REVERSED', 3)->hasSuccess());
        $this->assertFalse($this->status('REFUNDED', 3)->hasSuccess());
        $this->assertFalse($this->status('REVOKED', 3)->hasSuccess());

        $this->assertTrue($this->status('PAID', 1)->hasSuccess());

        $this->assertFalse($this->status('UNKNOWN', 7)->hasSuccess());

        $this->assertFalse($this->status('UNKNOWN', 7)->hasSuccess('CREATED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasSuccess('REVERSED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->hasSuccess('REFUNDED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->hasSuccess('REVOKED'));

        $this->assertTrue($this->status('UNKNOWN', 7)->hasSuccess('PAID'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasSuccess('UNKNOWN'));
    }

    public function testHasFailed()
    {
        $this->assertFalse($this->status('CREATED')->hasFailed());

        $this->assertFalse($this->status('REVERSED', 3)->hasFailed());
        $this->assertFalse($this->status('REFUNDED', 3)->hasFailed());
        $this->assertFalse($this->status('REVOKED', 3)->hasFailed());

        $this->assertFalse($this->status('PAID', 1)->hasFailed());

        $this->assertFalse($this->status('UNKNOWN', 7)->hasFailed());

        $this->assertFalse($this->status('UNKNOWN', 7)->hasFailed('CREATED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasFailed('REVERSED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->hasFailed('REFUNDED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->hasFailed('REVOKED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasFailed('PAID'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasFailed('UNKNOWN'));
    }

    public function testHasRefunding()
    {
        $this->assertFalse($this->status('CREATED')->hasRefunding());

        $this->assertFalse($this->status('REVERSED', 3)->hasRefunding());
        $this->assertFalse($this->status('REFUNDED', 3)->hasRefunding());
        $this->assertFalse($this->status('REVOKED', 3)->hasRefunding());

        $this->assertFalse($this->status('PAID', 1)->hasRefunding());

        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunding());

        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunding('CREATED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunding('REVERSED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunding('REFUNDED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunding('REVOKED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunding('PAID'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunding('UNKNOWN'));
    }

    public function testHasRefunded()
    {
        $this->assertFalse($this->status('CREATED')->hasRefunded());

        $this->assertTrue($this->status('REVERSED', 3)->hasRefunded());
        $this->assertTrue($this->status('REFUNDED', 3)->hasRefunded());
        $this->assertTrue($this->status('REVOKED', 3)->hasRefunded());

        $this->assertFalse($this->status('PAID', 1)->hasRefunded());

        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunded());

        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunded('CREATED'));

        $this->assertTrue($this->status('UNKNOWN', 7)->hasRefunded('REVERSED'));
        $this->assertTrue($this->status('UNKNOWN', 7)->hasRefunded('REFUNDED'));
        $this->assertTrue($this->status('UNKNOWN', 7)->hasRefunded('REVOKED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunded('PAID'));

        $this->assertFalse($this->status('UNKNOWN', 7)->hasRefunded('UNKNOWN'));
    }

    public function testInProgress()
    {
        $this->assertTrue($this->status('CREATED')->inProgress());

        $this->assertFalse($this->status('REVERSED', 3)->inProgress());
        $this->assertFalse($this->status('REFUNDED', 3)->inProgress());
        $this->assertFalse($this->status('REVOKED', 3)->inProgress());

        $this->assertFalse($this->status('PAID', 1)->inProgress());

        $this->assertTrue($this->status('UNKNOWN', 7)->inProgress());
        $this->assertTrue($this->status('UNKNOWN', 7)->inProgress('CREATED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->inProgress('REVERSED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->inProgress('REFUNDED'));
        $this->assertFalse($this->status('UNKNOWN', 7)->inProgress('REVOKED'));

        $this->assertFalse($this->status('UNKNOWN', 7)->inProgress('PAID'));

        $this->assertTrue($this->status('UNKNOWN', 7)->inProgress('UNKNOWN'));
    }

    protected function status(string $name, int $status_id = 0): Statuses
    {
        $details = Details::make(compact('name'));

        return Statuses::make($this->model($details, $status_id));
    }
}
