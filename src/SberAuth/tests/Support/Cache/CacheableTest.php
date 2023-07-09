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

namespace Tests\Support\Cache;

use Illuminate\Support\Facades\Cache as CacheRepository;

class CacheableTest extends BaseTest
{
    public function testSet()
    {
        $key = $this->getKey();

        $this->assertFalse(CacheRepository::has($key));

        $this->getCache();

        $this->assertTrue(CacheRepository::has($key));

        $this->assertIsString(CacheRepository::get($key));
    }
}
