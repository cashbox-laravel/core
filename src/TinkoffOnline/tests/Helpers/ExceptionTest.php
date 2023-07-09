<?php

/*
 * This file is part of the "cashier-provider/tinkoff-online" project.
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
 * @see https://github.com/cashier-provider/tinkoff-online
 */

namespace Tests\Helpers;

use CashierProvider\Core\Exceptions\Http\BadRequestClientException;
use CashierProvider\Core\Exceptions\Http\BaseException;
use CashierProvider\Core\Exceptions\Http\BuyerNotFoundClientException;
use CashierProvider\Core\Exceptions\Http\ContactTheSellerClientException;
use CashierProvider\Tinkoff\Online\Exceptions\Manager;
use DragonCode\Contracts\Http\Builder as HttpBuilder;
use DragonCode\Support\Facades\Http\Builder;
use Tests\TestCase;

class ExceptionTest extends TestCase
{
    public function test7()
    {
        $this->expectException(BuyerNotFoundClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Buyer Not Found');
        $this->expectExceptionCode(404);

        $this->throw(7);
    }

    public function test7String()
    {
        $this->expectException(BuyerNotFoundClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Buyer Not Found');
        $this->expectExceptionCode(404);

        $this->throw('7');
    }

    public function test7Reason()
    {
        $this->expectException(BuyerNotFoundClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Foo Bar');
        $this->expectExceptionCode(404);

        $this->throw(7, 'Foo Bar');
    }

    public function test53()
    {
        $this->expectException(ContactTheSellerClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Contact The Seller');
        $this->expectExceptionCode(409);

        $this->throw(53);
    }

    public function test53String()
    {
        $this->expectException(ContactTheSellerClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Contact The Seller');
        $this->expectExceptionCode(409);

        $this->throw('53');
    }

    public function test53Reason()
    {
        $this->expectException(ContactTheSellerClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Foo Bar');
        $this->expectExceptionCode(409);

        $this->throw(53, 'Foo Bar');
    }

    public function testDefault()
    {
        $this->expectException(BadRequestClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Bad Request');
        $this->expectExceptionCode(400);

        $this->throw(10000);
    }

    public function testDefaultString()
    {
        $this->expectException(BadRequestClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Bad Request');
        $this->expectExceptionCode(400);

        $this->throw('10000');
    }

    public function testDefaultReason()
    {
        $this->expectException(BadRequestClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Foo Bar');
        $this->expectExceptionCode(400);

        $this->throw(10000, 'Foo Bar');
    }

    protected function throw($code, ?string $reason = null)
    {
        $this->manager()->throw($this->uri(), $code, [
            'Message' => $reason,
        ]);
    }

    protected function uri(): HttpBuilder
    {
        return Builder::parse('https://example.com/foo');
    }

    protected function manager(): Manager
    {
        return new Manager();
    }
}
