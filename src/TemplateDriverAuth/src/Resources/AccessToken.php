<?php

namespace CashierProvider\BankName\Auth\Resources;

use Helldar\Contracts\Cashier\Resources\AccessToken as AccessTokenContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;
use Illuminate\Support\Carbon;
use CashierProvider\BankName\Auth\Constants\Keys;

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
