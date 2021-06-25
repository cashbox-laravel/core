<?php

namespace Helldar\Cashier\Concerns;

use Helldar\Cashier\Contracts\Auth as AuthContract;
use Helldar\Cashier\DTO\Auth;
use Helldar\Cashier\Models\CashierDetail;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/** @mixin \Illuminate\Database\Eloquent\Model */
trait Casheable
{
    public function details(): MorphOne
    {
        return $this->morphOne(CashierDetail::class, 'item');
    }

    /**
     * If you need to define Client ID and Client Secret depending on any conditions,
     * you can use the `Helldar\Cashier\DTO\Auth` class call.
     *
     * @return \Helldar\Cashier\Contracts\Auth
     */
    public function cashierAuth(): AuthContract
    {
        return Auth::make();
        //     ->setClientId($this->order->company->banks->foo->client_id)
        //     ->setClientSecret($this->order->company->banks->foo->client_secret);
    }
}
