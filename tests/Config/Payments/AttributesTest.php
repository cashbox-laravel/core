<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Tests\Config\Payments;

use Helldar\Cashier\Config\Payments\Attributes;
use Tests\TestCase;

class AttributesTest extends TestCase
{
    public function testGet()
    {
        $attributes = $this->attributes();

        $this->assertSame('foo', $attributes->getType());
        $this->assertSame('bar', $attributes->getStatus());
        $this->assertSame('baz', $attributes->getCreatedAt());
    }

    protected function attributes(): Attributes
    {
        return Attributes::make([
            'type'       => 'foo',
            'status'     => 'bar',
            'created_at' => 'baz',
        ]);
    }
}
