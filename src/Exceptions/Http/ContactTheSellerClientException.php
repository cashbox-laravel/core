<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Http;

class ContactTheSellerClientException extends BaseException
{
    protected $status_code = 409;

    protected $reason = 'Contact The Seller';
}
