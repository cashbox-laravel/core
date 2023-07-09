<?php

/*
 * This file is part of the "cashier-provider/tinkoff-auth" project.
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
 * @see https://github.com/cashier-provider/tinkoff-auth
 */

declare(strict_types=1);

namespace Tests\Support\Hash;

use Carbon\Carbon as BaseCarbon;
use DateTimeInterface;
use CashierProvider\Tinkoff\Auth\Support\Hash;
use Helldar\Contracts\Cashier\Resources\AccessToken;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function testBasic()
    {
        $model = $this->model();

        $data = ['PaymentId' => self::PAYMENT_ID];

        $token = Hash::make()->get($model, $data, false);

        $this->assertInstanceOf(AccessToken::class, $token);

        $this->assertSame(self::TERMINAL_KEY, $token->getClientId());
        $this->assertSame(self::TOKEN, $token->getAccessToken());

        $this->assertInstanceOf(Carbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(BaseCarbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(DateTimeInterface::class, $token->getExpiresIn());

        $this->assertGreaterThan(Carbon::now(), $token->getExpiresIn());
    }

    public function testHash()
    {
        $model = $this->model();

        $data = ['PaymentId' => self::PAYMENT_ID];

        $token = Hash::make()->get($model, $data);

        $this->assertInstanceOf(AccessToken::class, $token);

        $this->assertSame(self::TERMINAL_KEY, $token->getClientId());
        $this->assertSame(self::TOKEN_HASH, $token->getAccessToken());

        $this->assertInstanceOf(Carbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(BaseCarbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(DateTimeInterface::class, $token->getExpiresIn());

        $this->assertGreaterThan(Carbon::now(), $token->getExpiresIn());
    }

    public function testWrongHash()
    {
        $model = $this->model();

        $data = ['PaymentId' => '123'];

        $token = Hash::make()->get($model, $data);

        $this->assertInstanceOf(AccessToken::class, $token);

        $this->assertSame(self::TERMINAL_KEY, $token->getClientId());
        $this->assertNotSame(self::TOKEN_HASH, $token->getAccessToken());

        $this->assertInstanceOf(Carbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(BaseCarbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(DateTimeInterface::class, $token->getExpiresIn());

        $this->assertGreaterThan(Carbon::now(), $token->getExpiresIn());
    }
}
