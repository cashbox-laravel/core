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

namespace Tests\Support\Hash;

use Carbon\Carbon as BaseCarbon;
use DateTimeInterface;
use CashierProvider\Sber\Auth\Support\Hash;
use Helldar\Contracts\Cashier\Resources\AccessToken;
use Helldar\Support\Facades\Http\Builder;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class GetTest extends TestCase
{
    protected $uri_create = 'https://dev.api.sberbank.ru/ru/prod/order/v1/creation';

    public function testBasic()
    {
        $model = $this->model();

        $uri = Builder::parse($this->uri_create);

        $token = Hash::make()->get($model, $uri, self::SCOPE_CREATE);

        $this->assertInstanceOf(AccessToken::class, $token);

        $this->assertSame($this->clientId(), $token->getClientId());

        $this->assertMatchesRegularExpression(
            '/^[\w]{8}-[\w]{4}-[\w]{4}-[\w]{4}-[\w]{12}$/',
            $token->getAccessToken()
        );

        $this->assertInstanceOf(Carbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(BaseCarbon::class, $token->getExpiresIn());
        $this->assertInstanceOf(DateTimeInterface::class, $token->getExpiresIn());

        $this->assertGreaterThan(Carbon::now(), $token->getExpiresIn());
    }
}
