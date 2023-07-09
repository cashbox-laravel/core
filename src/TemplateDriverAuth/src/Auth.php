<?php

declare(strict_types=1);

namespace CashierProvider\BankName\Auth;

use Helldar\Contracts\Cashier\Auth\Auth as AuthContract;
use Helldar\Contracts\Cashier\Http\Request;
use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\Support\Concerns\Makeable;
use CashierProvider\BankName\Auth\Constants\Keys;
use CashierProvider\BankName\Auth\Resources\AccessToken;
use CashierProvider\BankName\Auth\Support\Hash;

/** @method static Auth make(Model $model, Request $request, bool $hash = true) */
class Auth implements AuthContract
{
    use Makeable;

    /** @var \Helldar\Contracts\Cashier\Resources\Model */
    protected $model;

    /** @var \Helldar\Contracts\Cashier\Http\Request */
    protected $request;

    /** @var bool */
    protected $hash;

    public function __construct(Model $model, Request $request, bool $hash = true, array $extra = [])
    {
        $this->model   = $model;
        $this->request = $request;
        $this->hash    = $hash;
    }

    public function headers(): array
    {
        return $this->request->getRawHeaders();
    }

    public function body(): array
    {
        $token = $this->getAccessToken();

        return array_merge($this->request->getRawBody(), [
            Keys::TERMINAL => $token->getClientId(),
            Keys::TOKEN    => $token->getAccessToken(),
        ]);
    }

    public function refresh(): void
    {
    }

    protected function getAccessToken(): AccessToken
    {
        return Hash::make()->get(
            $this->model,
            $this->request->getRawBody(),
            $this->hash
        );
    }
}
