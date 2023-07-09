<?php

/*
 * This file is part of the "cashier-provider/sber-auth" project.
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
 * @see https://github.com/cashier-provider/sber-auth
 */

declare(strict_types=1);

namespace Tests\Auth;

use CashierProvider\Sber\Auth\Auth;
use Tests\TestCase;

class BodyTest extends TestCase
{
    public function testBasic()
    {
        $auth = Auth::make($this->model(), $this->request());

        $this->assertIsArray($auth->body());

        $this->assertSame([
            'PaymentId' => self::PAYMENT_ID,
            'Sum'       => self::SUM_RESULT,
            'Currency'  => self::CURRENCY_RESULT,
            'CreatedAt' => self::CREATED_AT_RESULT,
        ], $auth->body());
    }
}
