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

use CashierProvider\Core\Exceptions\Http\BadRequestClientException;
use CashierProvider\Core\Exceptions\Http\BankInternalErrorException;
use CashierProvider\Core\Exceptions\Http\BaseException;
use CashierProvider\Sber\QrCode\Exceptions\Manager;
use Helldar\Contracts\Http\Builder as HttpBuilder;
use Helldar\Support\Facades\Http\Builder;
use Tests\TestCase;

class ExceptionTest extends TestCase
{
    public function test400()
    {
        $this->expectException(BadRequestClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Bad Request');
        $this->expectExceptionCode(400);

        $this->throw(400);
    }

    public function test400String()
    {
        $this->expectException(BadRequestClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Bad Request');
        $this->expectExceptionCode(400);

        $this->throw('400');
    }

    public function test400Reason()
    {
        $this->expectException(BadRequestClientException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Foo Bar');
        $this->expectExceptionCode(400);

        $this->throw(400, 'Foo Bar');
    }

    public function test500()
    {
        $this->expectException(BankInternalErrorException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Internal error of the bank system');
        $this->expectExceptionCode(400);

        $this->throw(500);
    }

    public function test500String()
    {
        $this->expectException(BankInternalErrorException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Internal error of the bank system');
        $this->expectExceptionCode(400);

        $this->throw('500');
    }

    public function test500Reason()
    {
        $this->expectException(BankInternalErrorException::class);
        $this->expectException(BaseException::class);
        $this->expectExceptionMessage('https://example.com/foo: Foo Bar');
        $this->expectExceptionCode(400);

        $this->throw(500, 'Foo Bar');
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

    protected function throw($code, string $reason = null)
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
