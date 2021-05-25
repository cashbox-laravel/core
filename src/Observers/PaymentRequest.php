<?php

namespace Helldar\Cashier\Observers;

use Carbon\Carbon;
use Helldar\Cashier\Models\PaymentRequest as Model;

final class PaymentRequest
{
    public function creating(Model $request)
    {
        $request->created_at = Carbon::now();
    }
}
