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

declare(strict_types=1);

namespace CashierProvider\Tinkoff\Online\Requests;

use CashierProvider\Core\Http\Request;
use CashierProvider\Core\Support\URI;
use CashierProvider\Tinkoff\Auth\Auth;

abstract class BaseRequest extends Request
{
    protected $host = 'https://securepay.tinkoff.ru';

    protected $auth = Auth::class;

    public function getRawHeaders(): array
    {
        return [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function getUriBuilder(): URI
    {
        return URI::make($this->host, null);
    }
}
