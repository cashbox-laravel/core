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

namespace CashierProvider\Tinkoff\Auth\Resources;

use CashierProvider\Tinkoff\Auth\Constants\Keys;
use Helldar\Contracts\Cashier\Resources\AccessToken as AccessTokenContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;
use Illuminate\Support\Carbon;

class AccessToken extends DataTransferObject implements AccessTokenContract
{
    protected $client_id;

    protected $access_token;

    protected $map = [
        Keys::TERMINAL => 'client_id',
        Keys::TOKEN    => 'access_token',
    ];

    public function getClientId(): string
    {
        return $this->client_id;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getExpiresIn(): Carbon
    {
        return Carbon::now()->addDay();
    }
}
