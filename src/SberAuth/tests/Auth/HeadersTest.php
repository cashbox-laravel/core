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
use DragonCode\Support\Facades\Helpers\Arr;
use Tests\TestCase;

class HeadersTest extends TestCase
{
    public function testBasic()
    {
        $auth = Auth::make($this->model(), $this->request(), true, [
            'scope' => self::SCOPE_CREATE,
        ]);

        $this->assertIsArray($auth->headers());

        $this->assertArrayHasKey('Accept', $auth->headers());
        $this->assertArrayHasKey('Authorization', $auth->headers());

        $this->assertSame('application/json', Arr::get($auth->headers(), 'Accept'));

        $this->assertMatchesRegularExpression(
            '/^Bearer\s[\w]{8}-[\w]{4}-[\w]{4}-[\w]{4}-[\w]{12}$/',
            Arr::get($auth->headers(), 'Authorization')
        );
    }
}
